
jQuery(document).ready(function($) {
    $('#ukmc-form').on('submit', function(e) {
        e.preventDefault();

        let price = parseFloat($('#property_price').val());
        let deposit = parseFloat($('#deposit_amount').val());
        let term = parseInt($('#mortgage_term').val());
        let interest = parseFloat($('#interest_rate').val()) / 100;
        let region = $('#property_location').val();
        let buyer = $('#buyer_type').val();

        let loan = price - deposit;
        let monthlyRate = interest / 12;
        let months = term * 12;

        let repayment = loan * monthlyRate / (1 - Math.pow(1 + monthlyRate, -months));
        let interestOnly = loan * monthlyRate;

        let stampDuty = calculateStampDuty(price, region, buyer);

        $('#ukmc-results').html(`
            <h3>Results:</h3>
            <p><strong>Repayment Mortgage:</strong> £${repayment.toFixed(2)}  Per Month</p>
            <p><strong>Interest-Only Mortgage:</strong> £${interestOnly.toFixed(2)}  Per Month</p>
            <p><strong>Estimated Stamp Duty:</strong> £${stampDuty.toLocaleString()}</p>
        `);
    });

    function calculateStampDuty(price, region, buyer) {
        let sd = 0;
        let extraRate = (buyer === 'additional') ? 0.03 : 0;
        if (region === 'england' || region === 'ni') {
            if (buyer === 'first_time') {
                if (price <= 425000) return 0;
                if (price <= 625000) return (price - 425000) * 0.05;
            }
            if (price <= 250000) return price * extraRate;
            if (price <= 925000) sd = (price - 250000) * 0.05;
            else sd = (925000 - 250000) * 0.05 + (price - 925000) * 0.1;
        } else if (region === 'wales') {
            if (price <= 225000) return price * extraRate;
            if (price <= 400000) sd = (price - 225000) * 0.06;
            else sd = (400000 - 225000) * 0.06 + (price - 400000) * 0.075;
        } else if (region === 'scotland') {
            if (price <= 145000) return price * extraRate;
            if (price <= 250000) sd = (price - 145000) * 0.02;
            else sd = (250000 - 145000) * 0.02 + (price - 250000) * 0.05;
        }
        return sd + price * extraRate;
    }
});
