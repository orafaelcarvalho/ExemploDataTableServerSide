<?php

    if(isset($_POST['tipoRelatorio'])){
        
        include 'conexao.php';
        session_start();
        
        // recuperando dados do data table da página resultado.php
        $params = $columns = $totalRecords = $data = array();
        $params = $_REQUEST;

        $columns = array(
            0 => 'id',
            1 => 'nome',
            2 => 'cpf', 
            3 => 'nis',
            4 => 'cras',
            5 => 'localentrega',
            6 => 'Acao'
            );

        // montando o where
        $where="where";
        
        // filtro por CRAS
        if($_POST ['columns'][4]['search']['value']!=""){
            $where .= " (cras = '".$_POST ['columns'][4]['search']['value']."') and";
        }

        // filtro por local de entrega
        if($_POST ['columns'][5]['search']['value']!=""){
            $where .= " (localentrega = '".$_POST ['columns'][5]['search']['value']."') and";
        }

        // montando o where com base na pesquisa do datatable
        if($_POST['search']['value']!=""){
            $where .= " (id LIKE '%".$_POST['search']['value']."%'";
            $where .= " or nome LIKE '%".$_POST['search']['value']."%'";
            $where .= " or cpf LIKE '%".$_POST['search']['value']."%'";
            $where .= " or nis LIKE '%".$_POST['search']['value']."%'";
            $where .= " or cras LIKE '%".$_POST['search']['value']."%'";
            $where .= " or localentrega LIKE '%".$_POST['search']['value']."%') and";
        }

        // montando o where com base no relatório que o usuário selecionou
        switch ($_POST['tipoRelatorio']) {
            case 'cestasentregues':
                $where .= ' dataentrega IS NOT NULL';
                break;
            case 'cestasnaoretiradas':
                $where .= ' dataentrega IS NULL';
                break;
        }

        // campanha
        $where .= " and (id_campanha = 1)";

        // contando o tamanho do resultado da pesquisa do usuário
        $sql1 = "select count(cpf) as quantidade from cadastro ".$where;
        $sql_query1  = mysqli_query($con,$sql1);
        $recordsTotal = mysqli_fetch_assoc($sql_query1);

        // select para paginação do resultado da pesquisa
        $sql2 = "select * from cadastro ".$where;
        $sql2 .= " order by ".$columns[$params['order'][0]['column']]." ".$params['order'][0]['dir'];
        $sql2 .= " LIMIT ".$params['length']." OFFSET ".$params['start'];
        $sql_query2  = mysqli_query($con,$sql2);
        $recordsFiltered = mysqli_num_rows($sql_query2);
        //echo $sql2;

        // montando o array com os dados
        $lista = array();
        if($recordsFiltered>0) {
            foreach($sql_query2 as $result2) {
                $lista[] = array($result2["id"],
                                $result2["nome"],
                                $result2["cpf"],
                                $result2["nis"],
                                $result2["cras"],
                                $result2["localentrega"],
                                // botão para abrir o modal detalhes
                                '<form action="consultar.php" method="post">
                                    <input type="hidden" name="cpf" value="'.$result2["cpf"].'">
                                    <button class="mybtndetalhes-datatable" type="submit">Detalhes</button>
                                </form>');
                            }
        }

        $json_data = array(
            "draw"            => ($params['draw']),
            "recordsTotal"    => ($recordsTotal['quantidade']),
            "recordsFiltered" => ($recordsTotal['quantidade']),
            "data"            => ($lista)
            );

        echo json_encode($json_data);

    }else{

        header('Location:usuario_logout.php');

    }
    
?>