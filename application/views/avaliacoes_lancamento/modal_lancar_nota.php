<link href="<?=base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
<!-- <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet"> -->
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

        .radio label:after {
            content: '';
            display: table;
            clear: both;
        }

        .radio .cr {
            position: relative;
            display: inline-block;
            border: 1px solid #a9a9a9;
            border-radius: .25em;
            width: 1.3em;
            height: 1.3em;
            float: left;
            margin-right: .5em;
        }

        .radio .cr {
            border-radius: 50%;
        }

        .radio .cr .cr-icon {
            position: absolute;
            font-size: .8em;
            line-height: 0;
            top: 50%;
            left: 20%;
        }

        .radio .cr .cr-icon {
            margin-left: 0.04em;
        }

        .radio label input[type="radio"] {
            display: none;
        }

        .radio label input[type="radio"] + .cr > .cr-icon {
            transform: scale(3) rotateZ(-20deg);
            opacity: 0;
            transition: all .3s ease-in;
        }

        .radio label input[type="radio"]:checked + .cr > .cr-icon {
            transform: scale(1) rotateZ(0deg);
            opacity: 1;
        }

        .radio label input[type="radio"]:disabled + .cr {
            opacity: .5;
        }
        .td_linha_opcao{
            width: 90px;
            /*border: 1px solid black;*/
        }
        .td_linha_texto{
            line-height:7px;
            text-align: left;
            /*border: 1px solid black;*/
        }
    </style>
    <script src="<?=base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?=base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <!-- Trigger/Open The Modal -->
    <!-- <button id="myBtn">Open Modal</button> -->
    <!-- The Modal -->
    
    
    <div id="myModal" class="modal">

      <!-- Modal content -->
      <div class="modal-content">
        <span class="close">&times;</span>
            
            <?php
                echo form_open('avaliacao/avaliacoes_lancamentos/salvar',array('id'=>'frm_avaliacoes_lancamentos','method'=>'post', 'enctype'=>'multipart/form-data', 'onsubmit' => "selecionarAllOptions()"));
                ?>
                    <input type="hidden" name="cd_aluno" value="<?php echo $cd_aluno; ?>">
                <?php
                $ci_avaliacao_itens = '';
                foreach ($registros as $i => $result) {

            ?>
                <div class="modal-body mx-3">
                    

                    <div>
                        <div>
                            
                            <?php if ($i == 0){?>
                                <div>
                                    
                                    <p><legend>Nome: <?php echo $nm_aluno; ?> - Avaliação: <?php echo $result->nm_caderno; ?></legend></p>
                                    <strong>Edicao:</strong> <?php echo $result->nm_edicao; ?>
                                    <strong>Tipo de Avaliação:</strong> <?php echo $result->nm_avalia_tipo; ?>  
                                    <strong>Disciplina:</strong> <?php echo $result->nm_disciplina; ?>
                                    <strong>Etapa:</strong> <?php echo $result->nm_etapa; ?>
                                    <strong>Ano:</strong> <?php echo $result->nr_ano; ?>
            <!--                    <strong>Competência:</strong> Vivenciando as medidas. <br>
                                    <strong>Habilidade:</strong> Calcular o volume de prismas, pirâmides, cilindros e cones em situação-problema. <br>
            -->

                                </div>
                                
                            <?php
                                    $ci_avaliacao_itens = $result->ci_avaliacao_itens;
                                }else{
                                    $ci_avaliacao_itens = $ci_avaliacao_itens.','.$result->ci_avaliacao_itens;
                                }
                            ?>
                            <div>
                                <?php echo $result->ds_enunciado; ?>
                            </div>

                            <div>
                                <input type="hidden" name="ci_avaliacao_itens" value="<?php echo $result->ci_avaliacao_itens; ?>">
                                <table style="width:100%">          
                                    <tr>
                                        <td class="td_linha_opcao">
                                            <p class="radio">  
                                                <label>
                                                    <input  type="radio" 
                                                            name="ci_avaliacao_itens_<?php echo $result->ci_avaliacao_itens;?>"
                                                            id="opcao_A_<?php echo $result->ci_avaliacao_itens;?>"
                                                            <?php if($result->nr_alternativa_escolhida == '1'){  echo 'checked'; } ?>
                                                            value="1">

                                                    <span class="cr"><i class="cr-icon glyphicon glyphicon-ok-sign"></i></span>
                                                    A)&nbsp;&nbsp;
                                                </label>
                                            </p>
                                        </td>
                                        <td class="td_linha_texto">
                                            &nbsp;&nbsp;
                                            <?php if ($result->tp_questao == 'I'){ ?>
                                                <img src="<?php echo base_url('assets/img/avalia_itens/'.$result->ds_img_item_01); ?>">
                                            <?php }else{ ?>
                                                <?php echo $result->ds_primeiro_item; ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="td_linha_opcao">
                                            <p class="radio">  
                                                <label>
                                                    <input  type="radio" 
                                                            name="ci_avaliacao_itens_<?php echo $result->ci_avaliacao_itens;?>"
                                                            id="opcao_B_<?php echo $result->ci_avaliacao_itens;?>"
                                                            <?php if($result->nr_alternativa_escolhida == '2'){  echo 'checked'; } ?>
                                                            value="2">

                                                    <span class="cr"><i class="cr-icon glyphicon glyphicon-ok-sign"></i></span>
                                                    B)&nbsp;&nbsp;
                                                </label>
                                            </p>
                                        </td>
                                        <td class="td_linha_texto">
                                            &nbsp;&nbsp;
                                            <?php if ($result->tp_questao == 'I'){ ?>
                                                <img src="<?php echo base_url('assets/img/avalia_itens/'.$result->ds_img_item_02); ?>">
                                            <?php }else{ ?>
                                                <?php echo $result->ds_segundo_item; ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="td_linha_opcao">
                                            <p class="radio">  
                                                <label>
                                                    <input  type="radio" 
                                                            name="ci_avaliacao_itens_<?php echo $result->ci_avaliacao_itens;?>"
                                                            id="opcao_C_<?php echo $result->ci_avaliacao_itens;?>"
                                                            <?php if($result->nr_alternativa_escolhida == '3'){  echo 'checked'; } ?>
                                                            value="3">

                                                    <span class="cr"><i class="cr-icon glyphicon glyphicon-ok-sign"></i></span>
                                                    C)&nbsp;&nbsp;
                                                </label>
                                            </p>
                                        </td>
                                        <td class="td_linha_texto">
                                            &nbsp;&nbsp;
                                            <?php if ($result->tp_questao == 'I'){ ?>
                                                <img src="<?php echo base_url('assets/img/avalia_itens/'.$result->ds_img_item_03); ?>">
                                            <?php }else{ ?>
                                                <?php echo $result->ds_terceiro_item; ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="td_linha_opcao">
                                            <p class="radio"> 
                                                <label>
                                                    <input  type="radio" 
                                                            name="ci_avaliacao_itens_<?php echo $result->ci_avaliacao_itens;?>"
                                                            id="opcao_D_<?php echo $result->ci_avaliacao_itens;?>"
                                                            <?php if($result->nr_alternativa_escolhida == '4'){  echo 'checked'; } ?>
                                                            value="4">

                                                    <span class="cr"><i class="cr-icon glyphicon glyphicon-ok-sign"></i></span>
                                                    D)&nbsp;&nbsp;
                                                </label>
                                            </p>
                                        </td>
                                        <td class="td_linha_texto">
                                            &nbsp;&nbsp;
                                            <?php if ($result->tp_questao == 'I'){ ?>
                                                <img src="<?php echo base_url('assets/img/avalia_itens/'.$result->ds_img_item_04); ?>">
                                            <?php }else{ ?>
                                                <?php echo $result->ds_quarto_item; ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>                    

                </div>
            <?php } ?>             
            <input type="hidden" name="ci_avaliacao_itens" value="<?php echo $ci_avaliacao_itens; ?>">      
            <div align="right">                                    
                <button type="submit" 
                        class="btn btn-custom waves-effect waves-light btn-micro active" 
                        tabindex="24">
                    Cadastrar
                </button>
            </div>

      </div>
      <?php
          echo form_close();
      ?>
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
