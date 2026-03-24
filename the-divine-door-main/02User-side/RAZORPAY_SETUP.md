# Razorpay Integration Setup Guide

This document explains how to set up and use the Razorpay payment gateway in your Divine Decor e-commerce platform.

## What is Razorpay?

Razorpay is a payment gateway that allows you to accept payments via:
- Credit/Debit Cards
- UPI (Unified Payments Interface)
- Wallets (Google Pay, Apple Pay, etc.)
- Net Banking
- BHIM

## Setup Instructions

### 1. Create Razorpay Account

1. Visit [https://razorpay.com](https://razorpay.com)
2. Sign up for a merchant account (free)
3. Verify your email and mobile number
4. Complete the KYC verification process
5. Your account will be activated within 1-2 business days

### 2. Get Your API Credentials

1. Log in to your Razorpay Dashboard
2. Go to **Settings** → **API Keys**
3. You'll see two keys:
   - **Key ID** (Public Key)
   - **Key Secret** (Private Key)

**IMPORTANT:** Keep your Key Secret safe and never share it!

### 3. Update Configuration Files

#### In checkout.php
Replace this line with your actual Key ID:
```javascript
const RAZORPAY_KEY_ID = 'YOUR_RAZORPAY_KEY_ID';
```

Example:
```javascript
const RAZORPAY_KEY_ID = 'rzp_live_abc123def456';
```

#### In config/razorpay_config.php
Replace both lines with your actual credentials:
```php
define('RAZORPAY_KEY_ID', 'YOUR_RAZORPAY_KEY_ID');
define('RAZORPAY_KEY_SECRET', 'YOUR_RAZORPAY_KEY_SECRET');
```

Example:
```php
define('RAZORPAY_KEY_ID', 'rzp_live_abc123def456');
define('RAZORPAY_KEY_SECRET', 'abcdef123456secret789');
```

### 4. Testing

Before going live, use Razorpay's test credentials:

**Test Key ID:** rzp_test_1Aa00000000001

**Test Key Secret:** YourTestKeySecret

Test Card Details:
- Card Number: 4111 1111 1111 1111
- Expiry: 12/25
- CVV: 123

### 5. Files Added

The following files were added to support Razorpay:

1. **02User-side/config/razorpay_config.php**
   - Contains API credentials and configuration
   - Functions to verify signatures and fetch payment details

2. **02User-side/functions/verify_razorpay_payment.php**
   - Verifies payment signature from Razorpay
   - Confirms payment status before creating order

3. **02User-side/checkout.php** (Updated)
   - Added Razorpay as a payment option
   - Integrated Razorpay checkout popup
   - Handles payment processing

## How It Works

1. **Customer selects Razorpay** at checkout
2. **Razorpay popup opens** when "Place Order" is clicked
3. **Customer enters payment details** (card, UPI, wallet, etc.)
4. **Payment is processed** by Razorpay
5. **Success callback triggers** and order is created
6. **Customer is redirected** to thank you page

## Payment Methods Supported

With Razorpay enabled, customers can pay via:

✓ Credit Cards (Visa, MasterCard, American Express)
✓ Debit Cards (All Indian Banks)
✓ UPI (Google Pay, PhonePe, BHIM, etc.)
✓ Wallets (Paytm, Amazon Pay, Airtel Money, etc.)
✓ Net Banking (All major Indian banks)

## Security Features

- **Encrypted transactions** using SSL/TLS
- **Signature verification** to prevent fraud
- **PCI-DSS compliant** payment processing
- **Encrypted sensitive data** storage

## Error Handling

If a payment fails:
- An error message is displayed to the customer
- No order is created
- Customer can retry with a different payment method

## Going Live

1. Complete KYC verification in your Razorpay account
2. Request for live mode access
3. Razorpay will activate your live account

Once live, update your API keys to production keys (starting with `rzp_live_`).

## Troubleshooting

### Issue: "Payment gateway not available"
- Solution: Check that Razorpay script is loaded: `<script src="https://checkout.razorpay.com/v1/checkout.js"></script>`

### Issue: "Invalid Key ID"
- Solution: Verify your Key ID is correct and matches the format `rzp_live_xxx` or `rzp_test_xxx`

### Issue: "Order creation failed"
- Solution: Check database connection and ensure `place_order.php` is working correctly

### Issue: "Customer details not pre-filled"
- Solution: Ensure form fields have correct IDs: `c_fname`, `c_lname`, `c_email_address`, `c_phone`

## Support

For issues or questions:
- Razorpay Support: https://razorpay.com/support
- Razorpay Documentation: https://razorpay.com/docs
- Email: support@razorpay.com

## Additional Notes

- Transactions are automatically captured after successful payment
- Refunds can be processed from Razorpay Dashboard
- Payment reports are available in Dashboard
- Settle payments directly to your bank account daily

---

**Last Updated:** March 2026
**Version:** 1.0
