<?php
$btn_color = get_option('ukmc_button_color', '#0073aa');
$btn_shape = get_option('ukmc_button_shape', 'rounded');
$btn_radius = get_option('ukmc_button_radius', '8');
?>
<?php $font_family = esc_attr(get_option('ukmc_font_family', 'Arial, sans-serif')); ?>
<div class="ukmc-form-container" style="font-family: <?php echo $font_family; ?>;">
    <h3>UK Mortgage & Stamp Duty Calculator</h3>
    <form id="ukmc-form">
        <label for="property_price">Property Price (£)</label>
        <input type="number" id="property_price" required>

        <label for="deposit_amount">Deposit Amount (£)</label>
        <input type="number" id="deposit_amount" required>

        <label for="mortgage_term">Mortgage Term (years)</label>
        <input type="number" id="mortgage_term" required>

        <label for="interest_rate">Interest Rate (%)</label>
        <input type="number" id="interest_rate" step="0.01" required>

        <label for="property_location">Property Location</label>
        <select id="property_location">
            <option value="england">England</option>
            <option value="scotland">Scotland</option>
            <option value="wales">Wales</option>
            <option value="ni">Northern Ireland</option>
        </select>

        <label for="buyer_type">Buyer Type</label>
        <select id="buyer_type">
            <option value="first_time">First-Time Buyer</option>
            <option value="home_mover">Home Mover</option>
            <option value="additional">Additional Property</option>
        </select>

        <button type="submit" 
            class="ukmc-button ukmc-<?php echo esc_attr($btn_shape); ?>" 
            style="background-color: <?php echo esc_attr($btn_color); ?>; border-radius: <?php echo esc_attr($btn_radius); ?>px;">
            Calculate
        </button>
    </form>
    <div id="ukmc-results" style="background-color: <?php echo esc_attr($btn_color); ?>20; border-radius: 10px; padding: 1rem; margin-top: 1rem;"></div>
</div>
