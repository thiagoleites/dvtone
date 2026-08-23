<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Fallback padrão dinâmico caso o campo esteja vazio no painel
$default_footer = sprintf(
    '&copy; %s %s. %s',
    date( 'Y' ),
    get_bloginfo( 'name' ),
    __( 'Todos os direitos reservados.', 'dvtone' )
);

// Resgata o texto salvo nas configurações do tema
$footer_text = dvtone_get_option( 'footer_text', $default_footer );
?>

<footer id="colophon" class="bg-white border-t border-slate-200 py-6 mt-auto">
    <div class="max-w-site mx-auto px-6 text-center">
        <p class="text-sm text-slate-500">
            <?php 
            // wp_kses_post permite tags seguras como links <a>, <strong>, etc.
            echo wp_kses_post( $footer_text ); 
            ?>
        </p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>