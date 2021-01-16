function gerarData(str) {
    var partes = str.split("/");
    return new Date(partes[2], partes[1] - 1, partes[0]);
}

function verificar_datas(dt_inicial, dt_final) {
    
    if (dt_inicial.length != 10 || dt_final.length != 10) return;

    if (gerarData(dt_final) <= gerarData(dt_inicial)){         
        return false;
    }else{
        return true;
    }
}