<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">    
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/autofill/2.3.7/css/autoFill.bootstrap5.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap5.min.css"/>

    <title>Exemplo Ajax DataTable</title>
  </head>
  <body>

    <div class="container">
      <div class="container-fluid" id="no-more-tables">

        <?php

            include "conexao.php";

            $sqlUnidade = 'select cras from cadastro where dataentrega IS NULL and id_campanha = 1  group by cras';
            $queryUnidade = mysqli_query($con,$sqlUnidade);

            $sqlLocalEntrega = 'select localentrega from cadastro where dataentrega IS NULL and id_campanha = 1 group by localentrega';
            $queryLocalEntrega = mysqli_query($con,$sqlLocalEntrega);

        ?>

        <div class="row">
          <div class="col-md-6">
            <!-- select para filtrar por CRAS -->
            <select class="form-control" id="selectCRAS">
              <option value="">Unidade - Todos</option>

              <?php

                foreach ($queryUnidade as $unidade){
                  echo '<option value="'.$unidade['cras'].'">Unidade - '.$unidade['cras'].'</option>';
                }

              ?>

            </select>
          </div>
          <div class="col-md-6">
            <!-- select para filtrar cadastros por local de entrega -->
            <select class="form-control" id="selectLocalEntrega">
              <option value="">Local de entrega - Todos</option>

              <?php
                
                foreach ($queryLocalEntrega as $localentrega) {
                  echo '<option value="'.$localentrega['localentrega'].'">Local de entrega - '.$localentrega['localentrega'].'</option>';
                } 
                
              ?>

            </select>
          </div>
        </div>    

        <!-- tabela do relatório -->
        <table id="relatorioCestas" class="table text-center">
          <thead class="hidden-xs">
              <tr>
                  <th width="7%">Código</th>
                  <th>Nome</th>
                  <th>CPF</th>
                  <th>NIS</th>
                  <th>Unidade</th>
                  <th>Local de entrega</th>
                  <th width="7%">Ação</th>
              </tr>
          </thead>
        </table>

      </div>
    </div>
    



    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/autofill/2.3.7/js/dataTables.autoFill.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/autofill/2.3.7/js/autoFill.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

    <script type="text/javascript">

      $(document).ready(function(){
          $('#relatorioCestas').DataTable({

              dom:
                "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-4'i><'col-sm-3 text-center'l><'col-sm-5'p>>",

              buttons: [
                  {
                      extend: 'print',
                      text: 'Imprimir',
                      className: 'mybtn-datatable',
                      title: 'Relatório Cestas Entregues',
                      exportOptions: {
                          columns: [ 0, 1, 2, 3, 4, 5 ],
                      }
                  },
                  {
                      extend: 'copyHtml5',
                      text: 'Copiar',
                      className: 'mybtn-datatable',
                      title: 'Relatório Cestas Entregues',
                      exportOptions: {
                          columns: [ 0, 1, 2, 3, 4, 5 ],
                      }
                  },
                  {
                      extend: 'excelHtml5',
                      className: 'mybtn-datatable',
                      title: 'Relatório Cestas Entregues',
                      exportOptions: {
                          columns: [ 0, 1, 2, 3, 4, 5 ],
                      }
                  },
                  {
                      extend: 'csvHtml5',
                      className: 'mybtn-datatable',
                      title: 'Relatório Cestas Entregues',
                      exportOptions: {
                          columns: [ 0, 1, 2, 3, 4, 5 ],
                      }
                  },
                  {
                      extend: 'pdfHtml5',
                      className: 'mybtn-datatable',
                      title: 'Relatório Cestas Entregues',
                      orientation: 'portrait',
                      exportOptions: {
                          columns: [ 0, 1, 2, 3, 4, 5 ],
                      }
                  },
                  {
                      extend: 'colvis',
                      text: 'Ocultar colunas',
                      className: 'mybtn-datatable',
                      columns: [ 0, 3, 4, 5, 6 ],
                      //columns: ':gt(2)',
                  }
              ],

              "language": {
                  "url": "traducao_pt_br.json"
              },

              // para funcionamento do css de tabela responsiva no-more-table
              createdRow: function( row, data, dataIndex ) {
                  $( row ).find('td:eq(0)').attr('data-title', 'Código');
                  $( row ).find('td:eq(1)').attr('data-title', 'Nome');
                  $( row ).find('td:eq(2)').attr('data-title', 'CPF');
                  $( row ).find('td:eq(3)').attr('data-title', 'NIS');
                  $( row ).find('td:eq(4)').attr('data-title', 'CRAS');
                  $( row ).find('td:eq(5)').attr('data-title', 'Entrega');
                  $( row ).find('td:eq(6)').attr('data-title', 'Ação');
                  $( row ).find('td:eq(6)').attr('class', 'text-center');
              },

              initComplete: function () {
                  // Apply the search
                  this.api().columns(4).every( function () {
                      var that = this;
      
                      $( '#selectCRAS', this.footer() ).on( 'keyup change clear', function () {
                          if ( that.search() !== this.value ) {
                              that
                                  .search( this.value )
                                  .draw();
                          }
                      } );
                  } );

                  this.api().columns(5).every( function () {
                      var that = this;
      
                      $( '#selectLocalEntrega', this.footer() ).on( 'keyup change clear', function () {
                          if ( that.search() !== this.value ) {
                              that
                                  .search( this.value )
                                  .draw();
                          }
                      } );
                  } );
              },

              "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 6 ] } ],
              "bFilter": true,
              'processing': true,
              'serverSide': true,
              'serverMethod': 'post',
              'ajax': {
                  'data': {tipoRelatorio: 'cestasnaoretiradas'},
                  'url':'busca_dados_relatorios.php'
              }
              
          });
          
      });

    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>