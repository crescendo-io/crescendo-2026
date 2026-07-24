<?php
$args = wp_parse_args(get_query_var('crescendo_prestation_tags_args', array()), array(
    'legend' => 'Type de projet',
    'hint' => 'Plusieurs choix possibles',
    'required' => false,
    'wrapper_class' => 'home-form__full',
    'default_values' => array(),
));

$options = crescendo_get_contact_projet_options();
$default_values = array_map('sanitize_key', (array) $args['default_values']);
?>
<fieldset
    class="crescendo-contact-form__tags <?php echo esc_attr($args['wrapper_class']); ?>"
    <?php echo !empty($args['required']) ? ' data-prestations-required="1"' : ''; ?>
>
    <?php if ($args['legend']) : ?>
        <legend class="crescendo-contact-form__tags-legend">
            <?php echo esc_html($args['legend']); ?><?php echo !empty($args['required']) ? ' *' : ''; ?>
            <?php if ($args['hint']) : ?>
                <span class="crescendo-contact-form__tags-hint"><?php echo esc_html($args['hint']); ?></span>
            <?php endif; ?>
        </legend>
    <?php endif; ?>

    <div class="crescendo-contact-form__tag-list">
        <?php foreach ($options as $value => $label) : ?>
            <label class="crescendo-contact-form__tag">
                <input
                    type="checkbox"
                    name="prestations[]"
                    value="<?php echo esc_attr($value); ?>"
                    <?php checked(in_array($value, $default_values, true)); ?>
                >
                <span><?php echo esc_html($label); ?></span>
            </label>
        <?php endforeach; ?>
    </div>
</fieldset>
