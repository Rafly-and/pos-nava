# NAVA Hardware POS Customization

NAVA Hardware branding adaptation of Dikasir for architectural hardware and smart-home retail.

## Brand palette
- Deep Charcoal: #25292B
- Warm Ivory: #F4F1EB
- Muted Brass: #A68C68
- Soft Stone: #D8D1C6
- Sage Grey: #68736D

## Included changes
- CSS design tokens and Tailwind primary/accent palettes updated to NAVA.
- NAVA wordmark/monogram for application logo, sidebar and mobile header.
- Dine-in navigation removed from sidebar.
- Product create/edit screens include a technical-specification guide in the existing description field.
- A4 sales invoice redesigned in charcoal, ivory and brass, retaining Dikasir's existing transaction data and barcode.
- App metadata updated to NAVA Hardware.
- Idempotent default categories for smart locks, handles, locksets, architectural accessories and smart-home security.

## Deployment checklist
1. Run `npm install`.
2. Run `npm run build`.
3. Set `APP_NAME="NAVA Hardware POS"` and `APP_DEBUG=false` in production.
4. Configure store name, logo, address, phone and email in Settings > Store Profile.
5. Review existing seeder behavior before running it against production data.
6. Run `php artisan optimize`.

## Scope and validation notes
- Checkout, payment, stock and discount transaction logic remains unchanged.
- Product technical specifications are entered in the existing description field in this branding pass. A future migration/controller/form update is required for normalized brand, model, finish, door thickness, mortise, access modes, serial number and warranty fields.
- The A4 document is a commercial sales invoice, not a claim of official tax-invoice compliance.
- Full Vite, PHP and PDF-rendering tests require a complete local checkout with dependencies installed.
