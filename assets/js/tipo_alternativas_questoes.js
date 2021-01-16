
function ocultarAlternativas(objeto){
  if(objeto.value == 'T'){
      $('#div_ds_primeiro_item_img').hide();
      $('#div_ds_primeiro_item_texto').show();

      $('#div_ds_segundo_item_img').hide();
      $('#div_ds_segundo_item_texto').show();

      $('#div_ds_terceiro_item_img').hide();
      $('#div_ds_terceiro_item_texto').show();

      $('#div_ds_quarto_item_img').hide();
      $('#div_ds_quarto_item_texto').show();
  }else{
      $('#div_ds_primeiro_item_img').show();
      $('#div_ds_primeiro_item_texto').hide();      
    
      $('#div_ds_segundo_item_img').show();
      $('#div_ds_segundo_item_texto').hide();   

      $('#div_ds_terceiro_item_img').show();
      $('#div_ds_terceiro_item_texto').hide();   

      $('#div_ds_quarto_item_img').show();
      $('#div_ds_quarto_item_texto').hide();   
  }

}