<style type="text/css">
    <!--
    /* == Pagination === */
    ul{border:0; margin:0; padding:0;}

    #pagination-digg li{
        border:0; margin:0; padding:0;
        IMAGEM    font-size:11px;
        list-style:none;
        margin-right:2px;
    }
    #pagination-digg a{
        border:solid 1px #c6baa4;
        margin-right:2px;
    }
    #pagination-digg a:link, #pagination-digg a:visited {
        color:#222222;
        display:block;
        float:left;
        padding:3px 6px;
        text-decoration:none;
    }
    #pagination-digg a:hover{
        border:solid 1px #222222
    }
    -->
</style>

<ul class="nav" id="nav1">
    <?php
    foreach($mensagens as $p){
        ?>
        <a href="#"
           onclick="escolher_escola('<?php echo $p->ci_escola?>', '<?php echo $p->nm_escola?>','<?php echo $p->nr_inep?>');"
           class="list-group-item list-group-item-action">
                <?php echo $p->nm_escola?>
        </a>
        <?php
    }
    ?>
</ul>
<ul id="pagination-digg">
    <?=$pag_links;?>
</ul>