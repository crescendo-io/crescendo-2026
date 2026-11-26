<?php
/** @deprecated Utiliser get_footer() — délègue au shell Studio. */
get_template_part('template-parts/general/studio', 'footer');
crescendo_render_contact_form_modal();
wp_footer();
echo '</div></body></html>';