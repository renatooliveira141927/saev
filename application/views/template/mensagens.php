
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/toastr.min.css'); ?>">
<script src="<?=base_url('assets/js/toastr.min.js'); ?>" type="text/javascript"></script>
<script>
    function mensagem_sucesso(tipo, meg){
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass": "toast-bottom-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "2000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr[tipo](meg);
    }

    function mensagem_excluir(){

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass": "toast-bottom-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "500",
            "hideDuration": "1000",
            "timeOut": 0,
            "extendedTimeOut": 0,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "tapToDismiss": false
        }
        toastr["error"]("Lembramos que após a confirmação não será possível desfazer!<br /><br /><button type=\"button\" class=\"btn btn-default clear\" onclick=\"ecluirregistro();\">Sim</button>", "Tem certeza que deseja apagar o registro?")
    }

    function ecluirregistro(){
        alert('Registro excluido!');
    }
    // mensagem_sucesso("success" , "Registro gravado com sucesso!");
    // mensagem_sucesso("error" , "Não foi possível realizar o cadastro!");
    //mensagem_excluir();
</script>