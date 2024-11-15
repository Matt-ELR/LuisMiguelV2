<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: pago.php'); // Redirect to login page if not logged in
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <script src="https://pay.google.com/gp/p/js/pay.js" async></script>
</head>
<body>
    <div class="payment-container">
        <h1>Proceed to Payment</h1>
        <p>To provide you with the best service, we require a small fee.</p>
        <div id="google-pay-button-container"></div>
    </div>

    <form id="payment-form" action="../0-php/controlPago.php" method="POST" style="display: none;">
        <input type="hidden" name="pago_id" id="pago_id">
        <input type="hidden" name="userId" value="<?php echo $_SESSION['usuario_id']; ?>">
        <input type="hidden" name="amount" value="1.00"> <!-- Set the amount here -->
        <input type="hidden" name="status" value="Exitoso"> <!-- Set the status here -->
    </form>

    <script>
        // Load the Google Pay API button
        function onGooglePayLoaded() {
            const paymentsClient = new google.payments.api.PaymentsClient({ environment: 'TEST' });

            const button = paymentsClient.createButton({ onClick: onGooglePaymentButtonClicked });
            document.getElementById('google-pay-button-container').appendChild(button);
        }

        // Handle button click
        function onGooglePaymentButtonClicked() {
            const paymentDataRequest = {
                apiVersion: 2,
                apiVersionMinor: 0,
                allowedPaymentMethods: [{
                    type: 'CARD',
                    parameters: {
                        allowedAuthMethods: ['PAN_ONLY', 'CRYPTOGRAM_3DS'],
                        allowedCardNetworks: ['MASTERCARD', 'VISA']
                    },
                    tokenizationSpecification: {
                        type: 'PAYMENT_GATEWAY',
                        parameters: {
                            gateway: 'example', // Replace 'example' with your gateway
                            gatewayMerchantId: 'exampleMerchantId' // Replace 'exampleMerchantId' with your gateway merchant ID
                        }
                    }
                }],
                merchantInfo: {
                    merchantId: 'your-merchant-id', // Replace with your test merchant ID
                    merchantName: 'Your Merchant Name' // Replace with your merchant name
                },
                transactionInfo: {
                    totalPriceStatus: 'FINAL',
                    totalPrice: '1.00', // Replace with the actual price
                    currencyCode: 'USD',
                    countryCode: 'US'
                }
            };

            const paymentsClient = new google.payments.api.PaymentsClient({ environment: 'TEST' });
            paymentsClient.loadPaymentData(paymentDataRequest)
                .then(paymentData => {
                    // Process payment data
                    console.log(paymentData); // Debug payment data
                    const transactionId = paymentData.paymentMethodData.tokenizationData.token;

                    // Set the transaction ID in the form
                    document.getElementById('pago_id').value = transactionId;

                    // Submit the form to the backend
                    document.getElementById('payment-form').submit();
                })
                .catch(err => {
                    console.error("Payment failed: ", err);
                    alert("Payment failed. Please try again.");
                });
        }
    </script>

    <script async src="https://pay.google.com/gp/p/js/pay.js?onload=onGooglePayLoaded"></script>
</body>
</html>
