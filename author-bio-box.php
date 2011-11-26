<?php
/*
Plugin Name: Author Bio Box
Plugin URI: http://www.ferramentasblog.com/2011/09/power-comment-validacao-de-comentarios.html
Description: Exiba um box com a biografia do autor dos posts e também links de redes sociais.
Author: Claudio Sanches
Version: 1.3
Author URI: http://www.claudiosmweb.com/
*/

// Criar menu para o plugin no WP
function add_authorbbox_menu() {
    add_options_page('Author Bio Box', 'Author Bio Box', 'manage_options', __FILE__, 'admin_authorbbox');
}
add_action('admin_menu', 'add_authorbbox_menu');
// Adicionar opcoes no DB
function set_authorbbox_options() {
    add_option('authorbbox_img','70');
    add_option('authorbbox_bg','#f8f8f8');
    add_option('authorbbox_bwidth','2');
    add_option('authorbbox_bstyle','Solida');
    add_option('authorbbox_bcolor','#cccccc');
    add_option('authorbbox_show','posts');
}
// Deleta opcoes quando o plugin &eacute; desinstalado
function unset_authorbbox_options() {
    delete_option('authorbbox_img');
    delete_option('authorbbox_bg');
    delete_option('authorbbox_bwidth');
    delete_option('authorbbox_bstyle');
    delete_option('authorbbox_bcolor');
    delete_option('authorbbox_show');
}
// instrucoes ao instalar ou desistalar o plugin
register_activation_hook(__FILE__,'set_authorbbox_options');
register_deactivation_hook(__FILE__,'unset_authorbbox_options');

// Pagina de opcoes
function admin_authorbbox() {
    ?>
    <div class="wrap">
        <div class="icon32" id="icon-options-general"><br /></div>
        <h2>Author Bio Box Op&ccedil;&otilde;es</h2>
        <?php 
        if(isset($_REQUEST['submit'])) {
            update_authorbbox_options();
        }
        print_authorbbox_form();
        ?>
    </div>
    <?php
}
// Validar op&ccedil;&otilde;es
function update_authorbbox_options() {
    $correto = false;
    // Tamanho da imagem
    if ($_REQUEST['authorbbox_img']) {
        update_option('authorbbox_img', $_REQUEST['authorbbox_img']);
        $correto = true;
    }
    // Cor de fundo
    if ($_REQUEST['authorbbox_bg']) {
        update_option('authorbbox_bg', $_REQUEST['authorbbox_bg']);
        $correto = true;
    }
    // Largura da borda
    if ($_REQUEST['authorbbox_bwidth']) {
        update_option('authorbbox_bwidth', $_REQUEST['authorbbox_bwidth']);
        $correto = true;
    }
    // Estilo da borda
    if ($_REQUEST['authorbbox_bstyle']) {
        update_option('authorbbox_bstyle', $_REQUEST['authorbbox_bstyle']);
        $correto = true;
    }
    // Cor da borda
    if ($_REQUEST['authorbbox_bcolor']) {
        update_option('authorbbox_bcolor', $_REQUEST['authorbbox_bcolor']);
        $correto = true;
    }
    // Onde mostrar
    if ($_REQUEST['authorbbox_show']) {
        update_option('authorbbox_show', $_REQUEST['authorbbox_show']);
        $correto = true;
    }
    if ($correto) {
        ?><div id="message" class="updated fade">
        <p><?php _e('Op&ccedil;&otilde;es salvas.'); ?></p>
        </div> <?php
    }
    else {
        ?><div id="message" class="error fade">
        <p><?php _e('Erro ao salvar op&ccedil;&otilde;es!'); ?></p>
        </div><?php
    }
}

// Formulario com as opcoes
function print_authorbbox_form() {
    $default_img = get_option('authorbbox_img');
    $default_bg = get_option('authorbbox_bg');
    $default_bwidth = get_option('authorbbox_bwidth');
    $default_bstyle = get_option('authorbbox_bstyle');
    $default_bstyle_options = array('Sem borda','Solida','Pontilhada','Tracejada');
    $default_bcolor = get_option('authorbbox_bcolor');
    $default_show = get_option('authorbbox_show');
    $authorbbox_plugin_dir = get_bloginfo('wpurl') . '/wp-content/plugins/author-bio-box/';
    ?>
    <form action="" method="post">
    <h3 style="margin: 20px 0 -5px;"><?php _e('Apar&ecirc;ncia'); ?></h3>
    <table class="form-table">
        <tr>
            <th scope="row"><label for="authorbbox_img_op"><?php _e('Tamanho da imagem do autor'); ?></label></th>
            <td>
                <input type="text" class="regular-text" name="authorbbox_img" id="authorbbox_img_op" value="<?php echo stripcslashes($default_img); ?>" />
                <br /><span class="description"><?php _e('Tamanho do gravatar do autor do blog. O autor precisa ter seu e-mail cadastrado com imagem no <a href="http://pt.gravatar.com/">Gravatar.com</a> (Aprenda como configurar seu gravatar <a href="http://gfsolucoes.net/gravatar-o-que-e-como-ter-um-como-colocar-em-seu-blog/">aqui</a>.)<br />(Insira n&uacute;meros inteiros).'); ?></span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="color_abb_bg_op"><?php _e('Cor de fundo'); ?></label></th>
            <td>
                <script type="text/javascript">
                    jQuery(document).ready(function() {
                        jQuery('#ilctabscolorpicker_abb_bg').hide();
                        jQuery('#ilctabscolorpicker_abb_bg').farbtastic("#color_abb_bg_op");
                        jQuery("#color_abb_bg_op").click(function(){jQuery('#ilctabscolorpicker_abb_bg').slideToggle()});
                    });
                </script>
                <input style="width:60px;" type="text" class="regular-text" name="authorbbox_bg" id="color_abb_bg_op" value="<?php echo $default_bg; ?>" />
                <div id="ilctabscolorpicker_abb_bg"></div>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="authorbbox_bwidth_op"><?php _e('Largura da borda'); ?></label></th>
            <td>
                <input type="text" class="regular-text" name="authorbbox_bwidth" id="authorbbox_bwidth_op" value="<?php echo stripcslashes($default_bwidth); ?>" />
                <br /><span class="description"><?php _e('Espessura da borda superior e inferior do box<br />(Insira n&uacute;meros inteiros).'); ?></span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="authorbbox_bstyle_op"><?php _e('Estilo da borda'); ?></label></th>
            <td>
                <select style="width:120px;" name="authorbbox_bstyle" id="authorbbox_bstyle_op">
                <?php foreach ($default_bstyle_options as $option) { ?>
                    <option <?php if ($default_bstyle == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="color_abb_border_op"><?php _e('Cor da borda'); ?></label></th>
            <td>
                <script type="text/javascript">
                    jQuery(document).ready(function() {
                        jQuery('#ilctabscolorpicker_abb_border').hide();
                        jQuery('#ilctabscolorpicker_abb_border').farbtastic("#color_abb_border_op");
                        jQuery("#color_abb_border_op").click(function(){jQuery('#ilctabscolorpicker_abb_border').slideToggle()});
                    });
                </script>
                <input style="width:60px;" type="text" class="regular-text" name="authorbbox_bcolor" id="color_abb_border_op" value="<?php echo $default_bcolor; ?>" />
                <div id="ilctabscolorpicker_abb_border"></div>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="authorbbox_show_op1"><?php _e('Mostrar plugin em'); ?></label></th>
            <td>
                <label><input type="radio" id="authorbbox_show_op1" name="authorbbox_show" value="posts" <?php if ($default_show == "posts") { _e('checked="checked"'); } ?> /> <?php _e('Apenas dentro dos Posts'); ?></label>
                <label><input style="margin:0 0 0 10px" type="radio" id="authorbbox_show_op2" name="authorbbox_show" value="home" <?php if ($default_show == "home") { _e('checked="checked"'); } ?>/> <?php _e('Na p&aacute;gina inicial e posts'); ?></label>
            </td>
            </td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" class="button-primary" name="submit" value="salvar" />
    </p>
    <p>
        <a style="margin-right:20px;" href="http://www.fbloghost.com/plano-wp-host/" target="_blank" title="FBlogHost - Hospedagem profissional para Worpdress">
            <img style="border:none;" src="<?php echo $authorbbox_plugin_dir; ?>/fbloghost.jpg" alt="FBlogHost - Hospedagem profissional para Worpdress" />
        </a>
        <a href="http://gfsolucoes.net/e-book-gratuito-como-transformar-seu-blogspot-em-um-blog-profissional/" target="_blank" title="Como transformar seu Blogspot em um Blog Profissional">
            <img style="border:none;" src="<?php echo $authorbbox_plugin_dir; ?>/gf-solucoes.png" alt="Como transformar seu Blogspot em um Blog Profissional" />
        </a>
    </p>
    </form>
<?php
}
// Chama Color Picker
function authorbbox_color() {
    wp_enqueue_style('farbtastic');
    wp_enqueue_script('farbtastic');
}
add_action('admin_menu', 'authorbbox_color');
// JS e CSS do plugin no head
function authorbbox_css_head() {
    $uthorbbox_css_bg = get_option('authorbbox_bg');
    $uthorbbox_css_bwidth = get_option('authorbbox_bwidth');
    $uthorbbox_css_bstyle = get_option('authorbbox_bstyle');
    $uthorbbox_css_bcolor = get_option('authorbbox_bcolor');
    switch($uthorbbox_css_bstyle) {
        case "Sem borda":
            $uthorbbox_css_bstyle = "none";
            break;
        case "Solida":
            $uthorbbox_css_bstyle = "solid";
            break;
        case "Pontilhada":
            $uthorbbox_css_bstyle = "dotted";
            break;
        case "Tracejada":
            $uthorbbox_css_bstyle = "dashed";
            break;
    }
    $author_show = get_option('authorbbox_show');
    switch($author_show) {
        case "posts":
            $author_show_in = is_single();
            break;
        case "home":
            $author_show_in = is_single() || is_home() || is_front_page();
            break;
    }
    if($author_show_in) {
        echo "<style type=\"text/css\">
    #blog-autor {border-width:".$uthorbbox_css_bwidth."px 0 ".$uthorbbox_css_bwidth."px;border-style:$uthorbbox_css_bstyle;border-color:$uthorbbox_css_bcolor;background:$uthorbbox_css_bg;padding:10px 10px 0;margin:10px 0;}
    #blog-autor h3,p#autor-desc {margin:0 0 10px;}
    #blog-autor a img {background:none;padding:0;margin:0 3px 0 0;border:none;opacity:1;transition:all 0.4s ease;-webkit-transition:all 0.4s ease;-o-transition:all 0.4s ease;-moz-transition:all 0.4s ease;}
    #blog-autor a:hover img {background:none;padding:0;border:none;opacity:0.7;}
    #autor-gravatar {float:left;}
    #autor-gravatar img {margin:0 15px 0 0;background:#fff;border:1px solid #ccc;padding:3px;}
    p#autor-social {margin:0 0 5px;}
    p#autor-footer {margin:0;padding:0;}
    .clear {clear:both;}
</style>\n";
    }
}
add_filter('wp_head', 'authorbbox_css_head');
// Modifica o perfil padr&atilde;o do Wordpress
function authorbbio_contact_edt($authorbbio_contact) {
    $authorbbio_contact['facebook'] = 'Facebook';
    $authorbbio_contact['twitter'] = 'Twitter';
    $authorbbio_contact['googleplus'] = 'Google Plus';
    $authorbbio_contact['linkedin'] = 'LinkedIn';
    unset($authorbbio_contact['aim']);
    unset($authorbbio_contact['yim']);
    unset($authorbbio_contact['jabber']);
    return $authorbbio_contact;
}
add_filter('user_contactmethods','authorbbio_contact_edt',10,1);
// Mostra facebook se existir link
function authorbbio_add_facebook() {
    $authorbbio_facebook = get_the_author_meta('facebook');
    $authorbbio_plugin_url = get_bloginfo('wpurl') . '/wp-content/plugins/author-bio-box/facebook.png';
    if($authorbbio_facebook == "" || $authorbbio_facebook == null) {
        return null;
    }
    else {
        return "<a target=\"_blank\" href=\"$authorbbio_facebook\"><img src=\"$authorbbio_plugin_url\" alt=\"facebook\" /></a>";
    }
}
// Mostra twitter se existir link
function authorbbio_add_twitter() {
    $authorbbio_twitter = get_the_author_meta('twitter');
    $authorbbio_plugin_url = get_bloginfo('wpurl') . '/wp-content/plugins/author-bio-box/twitter.png';
    if($authorbbio_twitter == "" || $authorbbio_twitter == null) {
        return null;
    }
    else {
        return "<a target=\"_blank\" href=\"$authorbbio_twitter\"><img src=\"$authorbbio_plugin_url\" alt=\"twitter\" /></a>";
    }
}
// Mostra google plus se existir link
function authorbbio_add_googleplus() {
    $authorbbio_googleplus = get_the_author_meta('googleplus');
    $authorbbio_plugin_url = get_bloginfo('wpurl') . '/wp-content/plugins/author-bio-box/google-plus.png';
    $authorbbio_linkedin = get_the_author_meta('linkedin');
    if($authorbbio_googleplus == "" || $authorbbio_googleplus == null) {
        return null;
    }
    else {
        return "<a target=\"_blank\" href=\"$authorbbio_googleplus\"><img src=\"$authorbbio_plugin_url\" alt=\"google plus\" /></a>";
    }
}
// Mostra linkedin se existir link
function authorbbio_add_linkedin() {
    $authorbbio_linkedin = get_the_author_meta('linkedin');
    $authorbbio_plugin_url = get_bloginfo('wpurl') . '/wp-content/plugins/author-bio-box/linkedin.png';
    if($authorbbio_linkedin == "" || $authorbbio_linkedin == null) {
        return null;
    }
    else {
        return "<a target=\"_blank\" href=\"$authorbbio_linkedin\"><img src=\"$authorbbio_plugin_url\" alt=\"linkedin\" /></a>";
    }
}
// Adiciona Author Bio Box
function authorbbio_add_box($content) {
    $authorbbio_imgsize = get_option('authorbbox_img');
    $authorbbio_name = get_the_author_meta('display_name');
    $authorbbio_posts = get_the_author_posts();
    $authorbbio_desc = get_the_author_meta('description');
    $authorbbio_desc_final = str_replace('<a href=', '<a target="_blank" href=', $authorbbio_desc);
    $authorbbio_blog_url = get_bloginfo('url');
    $authorbbio_id = get_the_author_meta('ID');
    $authorbbio_img = get_avatar($authorbbio_id, $authorbbio_imgsize);
    $authorbbio_info_facebook = authorbbio_add_facebook();
    $authorbbio_info_twitter = authorbbio_add_twitter();
    $authorbbio_info_googleplus = authorbbio_add_googleplus();
    $authorbbio_info_linkedin = authorbbio_add_linkedin();
    $authorbbio_content = "
<div id=\"blog-autor\">
    <div id=\"autor-bio\">
        <h3>$authorbbio_name</h3>
        <div id=\"autor-gravatar\">$authorbbio_img</div>
        <p id=\"autor-social\">$authorbbio_info_facebook $authorbbio_info_twitter $authorbbio_info_googleplus $authorbbio_info_linkedin</p>
        <p id=\"autor-desc\">$authorbbio_desc_final</p>
        <p id=\"autor-footer\"><a href=\"$authorbbio_blog_url/?author=$authorbbio_id\">$authorbbio_name</a> j&aacute; escreveu $authorbbio_posts posts.</p>
        <br class=\"clear\" />
    </div>
</div>\n";
    
    $author_show = get_option('authorbbox_show');
    switch($author_show) {
        case "posts":
            $author_show_in = is_single();
            break;
        case "home":
            $author_show_in = is_single() || is_home() || is_front_page();
            break;
    }
    if($author_show_in) {
        return $content . $authorbbio_content;
    }
    elseif(is_page()) {
        return $content;
    }
    else {
        return $content;
    }
}
add_filter('the_content', 'authorbbio_add_box', 1300);
?>