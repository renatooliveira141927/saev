    <style type="text/css">
        
        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 5; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }

        /* The Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
                
    </style>

    <!-- Trigger/Open The Modal -->
    <!-- <button id="myBtn">Open Modal</button> -->

    <!-- The Modal -->
    <div id="myModal" class="modal">

      <!-- Modal content -->
      <div class="modal-content">
        <span class="close">&times;</span>
        

            <?php
                foreach ($registros as $result) {
            ?>
                <div class="modal-header text-center">
                    <h3><center>Item de avaliação de nº. <?php echo $result->ci_avalia_item; ?></center></h3>
                    
                </div>
                <div class="modal-body mx-3">
                    

                    <div>
                        <div>

                            <div>
                                <p><legend>Parâmetros</legend></p>
                                <strong>Edicao:</strong> <?php echo $result->nm_edicao; ?>
                                <strong>Origem:</strong> <?php echo $result->nm_avalia_origem; ?> - 
                                <strong>Disciplina:</strong> <?php echo $result->nm_disciplina; ?>  -
                                <strong>Dificuldade:</strong> <?php echo $result->nm_avalia_dificuldade; ?> <br>
                                <strong>Etapa:</strong> <?php echo $result->nm_etapa; ?>
                                <strong>Conteúdo:</strong> <?php echo $result->nm_avalia_conteudo; ?>
                                <strong>Sub conteúdo:</strong> <?php echo $result->nm_avalia_subconteudo; ?>
        <!--                    <strong>Competência:</strong> Vivenciando as medidas. <br>
                                <strong>Habilidade:</strong> Calcular o volume de prismas, pirâmides, cilindros e cones em situação-problema. <br>
        -->
                            </div>

                            <div>
                                <p><legend>Enunciado</legend></p>
                                <?php echo $result->ds_enunciado; ?>
                            </div>

                            <div>
                                <p><legend>Suporte</legend></p>

                                <div align="center">
                                    <img class="img-responsive img-thumbnail" width="150" height="150" src="<?php echo base_url('assets/img/avalia_itens/'.$result->ds_img_suporte); ?>">   
                                </div>
                            </div>

                            <div>
                                <p><legend>Comando</legend></p>
                                <?php echo $result->ds_comando; ?>
                            </div>

                            <div>
                                <p><legend>Alternativas</legend></p>
                                <table>      
                                    <?php if ($result->tp_questao == 'I'){ ?> 
                                            
                                            <?php if ($result->nr_alternativa_correta == 1){ ?>
                                                <tr>
                                                    <td> <strong id="alteranativa_certa"><p>A) </p></strong> </td>
                                                    <td><img src="<?php echo base_url('assets/img/avalia_itens/'.$result->ds_img_item_01); ?>"></td>
                                                </tr>
                                            <?php }else{ ?>
                                                <tr>
                                                    <td><p>  A)  </p></td>
                                                    <td><img src="<?php echo base_url('assets/img/avalia_itens/'.$result->ds_img_item_01); ?>"></td>
                                                </tr>
                                            <?php } ?>
                                                                    
                                            <?php if ($result->nr_alternativa_correta == 2){ ?>
                                                <tr>
                                                    <td> <strong id="alteranativa_certa"><p>B) </p></strong> </td>
                                                    <td><img src="<?php echo base_url('assets/img/avalia_itens/'.$result->ds_img_item_02); ?>"></td> 
                                                </tr>
                                            <?php }else{ ?>
                                                <tr>
                                                    <td><p>  B)  </p></td>
                                                    <td><img src="<?php echo base_url('assets/img/avalia_itens/'.$result->ds_img_item_02); ?>"></td>
                                                </tr>
                                            <?php } ?>

                                            <?php if ($result->nr_alternativa_correta == 3){ ?>
                                                <tr>
                                                    <td> <strong id="alteranativa_certa"><p>C) </p></strong> </td>
                                                    <td><img src="<?php echo base_url('assets/img/avalia_itens/'.$result->ds_img_item_03); ?>"></td>
                                                </tr>
                                            <?php }else{ ?>
                                                <tr>
                                                    <td><p>  C)  </p></td>
                                                    <td><img src="<?php echo base_url('assets/img/avalia_itens/'.$result->ds_img_item_03); ?>"></td>
                                                </tr>
                                            <?php } ?>

                                            <?php if ($result->nr_alternativa_correta == 4){ ?>
                                                <tr>
                                                    <td> <strong id="alteranativa_certa"><p>D) </p></strong> </td>
                                                    <td><img src="<?php echo base_url('assets/img/avalia_itens/'.$result->ds_img_item_04); ?>"></td> 
                                                </tr>
                                            <?php }else{ ?>
                                                <tr>
                                                    <td><p>  D)  </p></td>
                                                    <td><img src="<?php echo base_url('assets/img/avalia_itens/'.$result->ds_img_item_04); ?>"></td>
                                                </tr>
                                            <?php } ?>
                                        </tr>
                                    <?php }else{ ?>
                                                                
                                        </tr>    
                                            <?php if ($result->nr_alternativa_correta == 1){ ?>
                                                <tr>
                                                    <td> <strong id="alteranativa_certa"><p>A) </p></strong> </td>
                                                    <td> <strong id="alteranativa_certa"> <?php echo $result->ds_primeiro_item; ?></strong> </td> 
                                                </tr>
                                            <?php }else{ ?>
                                                <tr>
                                                    <td><p>  A)  </p></td>
                                                    <td> <?php echo $result->ds_primeiro_item; ?>  </td>
                                                </tr>
                                            <?php } ?>
                                                                    
                                            <?php if ($result->nr_alternativa_correta == 2){ ?>
                                                <tr>
                                                    <td> <strong id="alteranativa_certa"><p>B) </p></strong> </td>
                                                    <td> <strong id="alteranativa_certa"> <?php echo $result->ds_segundo_item; ?></strong> </td> 
                                                </tr>
                                            <?php }else{ ?>
                                                <tr>
                                                    <td><p>  B)  </p></td>
                                                    <td> <?php echo $result->ds_segundo_item; ?>  </td>
                                                </tr>
                                            <?php } ?>

                                            <?php if ($result->nr_alternativa_correta == 3){ ?>
                                                <tr>
                                                    <td> <strong id="alteranativa_certa"><p>C) </p></strong> </td>
                                                    <td> <strong id="alteranativa_certa"> <?php echo $result->ds_terceiro_item; ?></strong> </td> 
                                                </tr>
                                            <?php }else{ ?>
                                                <tr>
                                                    <td><p>  C)  </p></td>
                                                    <td> <?php echo $result->ds_terceiro_item; ?>  </td>
                                                </tr>
                                            <?php } ?>

                                            <?php if ($result->nr_alternativa_correta == 4){ ?>
                                                <tr>
                                                    <td> <strong id="alteranativa_certa"><p>D) </p></strong> </td>
                                                    <td> <strong id="alteranativa_certa"> <?php echo $result->ds_quarto_item; ?></strong> </td> 
                                                </tr>
                                            <?php }else{ ?>
                                                <tr>
                                                    <td><p>  D)  </p></td>
                                                    <td> <?php echo $result->ds_quarto_item; ?>  </td>
                                                </tr>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>  
                                </table>

                            </div>
                        </div>
                    </div>                    

                </div>
            <?php } ?>                   



      </div>

    </div>
    <script>
        
        // Get the modal
        var modal = document.getElementById('myModal');

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on the button, open the modal 
      //  alert(btn);
        // btn.onclick = function() {
        //     modal.style.display = "block";
        // }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        modal.style.display = "block";
    </script>
