<?php
if (! is_user_logged_in() ) {
?>
<div class= "alert alert-danger" role="alert" style="margin-top: 20px">
    <h2> <strong>Acceso permitido solo a usuarios autentificados</strong> </h2>
</div>
<?php
} else {
?>
<?php
if (isset( $_POST[‘cpt_nonce_field’] ) && wp_verify_nonce( $_POST[‘cpt_nonce_field’], ‘cpt_nonce_action’ ) )
{
//     if (taxonomy_exists( 'valores' ))
//         {
//             echo "Si existe la taxonomia";
//             exit();
//         }
//     else {
//         echo 'No existe taxonomy';
//         exit();
//     }
    // $terms = get_terms( 'valores' );
    // print_r($_POST);
    $terms =  get_terms( $args = array ( 'taxonomy'=> 'valores',  'hide_empty' => false,) );
    foreach ( $terms as $term)
        echo $term->name . "<br />";
   
    if ( isset( $_POST['submitted'] ) ) {
        //Comprobar valor
        $valor = term_exists( $_POST['valores'], 'valores' );
        echo "termino: ".$_POST['valores'];
        if ( $valor > 0) {
            $post_information = array(
                'post_title' => wp_strip_all_tags( $_POST['postTitle'] ),
                'post_excerpt' => $_POST['postContent'],
                'post_content'  => $_POST['postContent'],
                'post_type' => 'reconocimiento',
                'post_status' => 'publish',
                // 'tax_input'     =>  $tax
            );
            $pid = wp_insert_post( $post_information, true );
            add_post_meta($pid, 'reconocimiento_usuario', $_POST['reconocimiento_usuario'], true);
            $term_taxonomy_ids = wp_set_object_terms( $pid, $_POST['valores'], 'valores', false );
            if ( is_wp_error( $term_taxonomy_ids ) ) {
                echo " Error al insertar la categoria";
            } else {
                echo " Se relaciona el termino con el post";
            }
        } else {
            echo "<h1> Error no existe termino: ". $valor."</h1>";
            echo "<h2> Valor: ". $valor."</h2>";
            print_r( $_POST['valores']);
        } //Si no existe el termino

    } // Si submit
    exit;
 }
?>
<form action="" id="primaryPostForm" method="POST">
    <div class="form-group">
        <label for="postTitle"><?php _e('Compañero:', 'framework') ?></label>
        <input type="text"  class="form-control" name="postTitle" id="postTitle" required />
        <small id="postTitleHelp" class="form-text text-muted">El nombre del compañero a reconocer</small>
    </div>
    <div class="form-group">                    
        <label for="postContent"><?php _e('Motivo del reconocimiento:', 'framework') ?></label>                                
        <textarea class="form-control" name="postContent" id="postContent" required></textarea>
        <small id="postTitleHelp" class="form-text text-muted">No mayor a 140 caracteres. </small>
        
    </div>
    <div class="form-group">
        <input type="hidden" name="submitted" id="submitted" value="true" />
        <input type="hidden" name="reconocimiento_usuario" id="reconocimiento_usuario" />
    </div>
    <div class="form-group">
        <h2>Valor a Reconocer</h2>
        <label for="btnAmor" class="btn btn-amor">Amor <input type="radio" id="btnAmor" name="valores" value="Amor" class="badgebox"><span class="badge">&check;</span></label>
        <label for="info" class="btn btn-honestidad">Honestidad <input type="radio" id="info" name="valores" value="Honestidad"  class="badgebox"><span class="badge">&check;</span></label>
        <label for="success" class="btn btn-responsabilidad">Responsabilidad <input type="radio" id="success" name="valores" value="Responsabilidad"  class="badgebox"><span class="badge">&check;</span></label>
        <label for="warning" class="btn btn-warning">Benedicencia <input type="radio" id="warning" name="valores"  value="Benedicencia" class="badgebox"><span class="badge">&check;</span></label>
        <label for="danger" class="btn btn-generosidad">Generosidad <input type="radio" id="danger" name="valores" value="Generosidad" class="badgebox"><span class="badge">&check;</span></label>
        <label for="primary1" class="btn btn-union">Unión <input type="radio" id="primary1" name="valores" value="Unión" class="badgebox"><span class="badge">&check;</span></label>
    </div>
    <div class="form-group">
    <?php wp_nonce_field( ‘cpt_nonce_action’, ‘cpt_nonce_field’ ); ?>
        <button id="postLoad" type="submit" class="btn btn-primary btn-lg btn-block" value="send"><?php _e('Enviar', 'framework') ?></button>
    </div>
</form>
<?php } ?>