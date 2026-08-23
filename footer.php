<footer id="colophon" class="bg-white border-t border-slate-200 py-6 mt-auto">
    <div class="max-w-site mx-auto px-6 text-center">
        <?php
        $footer_copy = get_theme_mod( 'footer_copyright_text', '' );
        ?>
        <p class="text-sm text-slate-500">
            <?php if ( ! empty( $footer_copy ) ) : ?>
                <?php echo esc_html( $footer_copy ); ?>
            <?php else : ?>
                &copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. Todos os direitos reservados.
            <?php endif; ?>
        </p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>