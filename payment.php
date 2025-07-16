<?php
session_start();
include 'includes/header.php';

if (!isset($_SESSION['order_id']) || !isset($_SESSION['total_price'])) {
    header("Location: shop.php");
    exit();
}

$order_id = $_SESSION['order_id'];
$total_price = $_SESSION['total_price'];
?>

<style>
    main {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 80px);
        padding: 20px;
        background: #f5f7fa;
    }

    .payment-container {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        padding: 30px;
        max-width: 600px;
        width: 100%;
        text-align: center;
    }

    .btn-payment {
        border-radius: 30px;
        padding: 12px 25px;
        width: 100%;
        margin-top: 15px;
    }

    /* Modal Styling */
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0,0,0,0.7);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: #fff;
        border-radius: 16px;
        padding: 30px;
        max-width: 400px;
        width: 90%;
        text-align: center;
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        animation: fadeIn 0.4s ease-out;
    }

    .modal-content button {
        display: block;
        width: 100%;
        margin: 10px 0;
        border-radius: 30px;
        padding: 10px 0;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .modal-content button:hover {
        transform: scale(1.03);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }
</style>

<main>
    <div class="payment-container">
        <h2>💳 Payment</h2>
        <p>Order ID: <strong>#<?= htmlspecialchars($order_id) ?></strong></p>
        <p>Total Amount: <strong>$<?= number_format($total_price, 2) ?></strong></p>

        <form id="paymentForm">
            <h5>Select Payment Method:</h5>
            <div class="form-check text-start">
                <input class="form-check-input" type="radio" name="payment_method" id="upi" value="UPI" required>
                <label class="form-check-label" for="upi">🏦 UPI (Google Pay, PhonePe)</label>
            </div>
            <div class="form-check text-start">
                <input class="form-check-input" type="radio" name="payment_method" id="card" value="Card">
                <label class="form-check-label" for="card">💳 Credit/Debit Card</label>
            </div>
            <div class="form-check text-start">
                <input class="form-check-input" type="radio" name="payment_method" id="netbanking" value="Net Banking">
                <label class="form-check-label" for="netbanking">🖥️ Net Banking</label>
            </div>
            <div class="form-check text-start">
                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="COD">
                <label class="form-check-label" for="cod">💵 Cash on Delivery (COD)</label>
            </div>

            <button type="submit" class="btn btn-success btn-payment">✅ Pay Now</button>
        </form>
    </div>
</main>

<!-- Modal -->
<div id="paymentModal" class="modal">
    <div class="modal-content" id="modalContent">
        <!-- Dynamic Content -->
    </div>
</div>

<script>
    const paymentForm = document.getElementById('paymentForm');
    const modal = document.getElementById('paymentModal');
    const modalContent = document.getElementById('modalContent');

    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const selectedPayment = document.querySelector('input[name="payment_method"]:checked').value;

        // Reset modal content first
        modalContent.innerHTML = '';

        if (selectedPayment === 'COD') {
            modalContent.innerHTML = `
                <h4>✅ Order Confirmed</h4>
                <p>Your order has been placed successfully! Pay on delivery.</p>
                <a href="shop.php" class="btn btn-primary">Continue Shopping</a>
            `;
        } else {
            modalContent.innerHTML = `
                <h4>🔄 Processing ${selectedPayment} Payment...</h4>
                <p>Please wait while we process your payment.</p>
                <div style="margin-top: 20px;">
                    <button class="btn btn-success" onclick="paymentSuccess()">✅ Simulate Success</button>
                    <button class="btn btn-danger" onclick="paymentFail()">❌ Simulate Failure</button>
                </div>
            `;
        }

        modal.style.display = 'flex';
    });

    function paymentSuccess() {
        modalContent.innerHTML = `
            <h4>✅ Payment Successful</h4>
            <p>Thank you for your purchase! Your order is confirmed.</p>
            <a href="shop.php" class="btn btn-primary">Continue Shopping</a>
        `;
    }

    function paymentFail() {
        modalContent.innerHTML = `
            <h4>❌ Payment Failed</h4>
            <p>We couldn't process your payment. Please try again or use another method.</p>
            <button class="btn btn-secondary" onclick="closeModal()">Try Again</button>
        `;
    }

    function closeModal() {
        modal.style.display = 'none';
        modalContent.innerHTML = ''; // Clear modal content when closed
    }
</script>

<?php include 'includes/footer.php'; ?>
