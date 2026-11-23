<x-guest-layout>
    <div class="max-w-4xl mx-auto py-6">
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-bold text-green-700">
                AgriPulse
            </h1>
            <h2 class="text-2xl font-semibold text-gray-800 mt-2">
                Terms and Conditions
            </h2>
            <p class="text-sm text-gray-500 mt-2">
                The Heartbeat of Local Agriculture
            </p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm space-y-5 text-gray-700">

            <p>
                Welcome to AgriPulse! By creating an account and using
                our platform, you agree to follow these Terms and Conditions.
                Please read them carefully before using our services.
            </p>

            <section>
                <h3 class="font-bold text-lg text-green-700">1. About AgriPulse</h3>
                <p>
                    AgriPulse is an online marketplace that connects farmers
                    with customers. Farmers can list and sell their agricultural
                    products, while customers can browse and purchase available
                    products through the platform.
                </p>
            </section>

            <section>
                <h3 class="font-bold text-lg text-green-700">2. Account Registration</h3>
                <ul class="list-disc ml-6 space-y-1">
                    <li>Users must provide accurate and complete information.</li>
                    <li>Users must keep their login information secure.</li>
                    <li>Users must not create accounts using false identities.</li>
                    <li>Users are responsible for activities performed through their accounts.</li>
                </ul>
            </section>

            <section>
                <h3 class="font-bold text-lg text-green-700">3. Farmer Responsibilities</h3>
                <ul class="list-disc ml-6 space-y-1">
                    <li>Farmers must provide accurate product descriptions, prices, and quantities.</li>
                    <li>Product photos should represent the actual products being sold.</li>
                    <li>Farmers must maintain accurate stock and expiration information where applicable.</li>
                    <li>Farmers must process and update customer orders responsibly.</li>
                </ul>
            </section>

            <section>
                <h3 class="font-bold text-lg text-green-700">4. Customer Responsibilities</h3>
                <ul class="list-disc ml-6 space-y-1">
                    <li>Customers must provide accurate delivery addresses and contact numbers.</li>
                    <li>Customers should review their orders before confirming purchases.</li>
                    <li>Customers must select an available payment method.</li>
                    <li>Customers should communicate responsibly regarding their orders.</li>
                </ul>
            </section>

            <section>
                <h3 class="font-bold text-lg text-green-700">5. Orders and Payments</h3>
                <p>
                    Orders are subject to product availability. AgriPulse may
                    support payment methods such as GCash and Cash on Delivery
                    (COD). Customers must follow the payment instructions
                    displayed during checkout.
                </p>
            </section>

            <section>
                <h3 class="font-bold text-lg text-green-700">6. Product Information</h3>
                <p>
                    Farmers are responsible for the accuracy of their product
                    information. Customers should review product descriptions,
                    prices, quantities, and other available details before
                    purchasing.
                </p>
            </section>

            <section>
                <h3 class="font-bold text-lg text-green-700">7. Prohibited Activities</h3>
                <p>Users must not:</p>
                <ul class="list-disc ml-6 space-y-1">
                    <li>Post misleading or fraudulent product information.</li>
                    <li>Use the platform for illegal activities.</li>
                    <li>Attempt to access another user's account without permission.</li>
                    <li>Disrupt or misuse the platform.</li>
                </ul>
            </section>

            <section>
                <h3 class="font-bold text-lg text-green-700">8. Account Suspension</h3>
                <p>
                    AgriPulse administrators may review accounts and take
                    appropriate action when users violate these Terms and
                    Conditions or misuse the platform.
                </p>
            </section>

            <section>
                <h3 class="font-bold text-lg text-green-700">9. Changes to These Terms</h3>
                <p>
                    AgriPulse may update these Terms and Conditions when
                    necessary. Users will be informed of significant changes
                    and may be asked to accept the updated terms before
                    continuing to use the platform.
                </p>
            </section>

            <section>
                <h3 class="font-bold text-lg text-green-700">10. Contact and Support</h3>
                <p>
                    For questions or concerns about these Terms and Conditions,
                    users may contact the AgriPulse platform administrator
                    through the available support channels.
                </p>
            </section>

            <div class="border-t pt-5 text-sm text-gray-500">
                By registering for an AgriPulse account, you confirm that
                you have read and agree to these Terms and Conditions.
            </div>

            <div class="flex justify-between items-center pt-3">
                <a href="{{ route('register') }}"
                   class="text-green-700 hover:text-green-900 underline">
                    Back to Registration
                </a>

                <a href="{{ route('privacy') }}"
                   class="text-green-700 hover:text-green-900 underline">
                    Read Privacy Policy →
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>