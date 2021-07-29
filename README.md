# TIL Bookings Offer Expiry Plugin for Wordpress

This plugin allows a booking with status "Accepted" to be automatically
changed to status "Declined" after a time limit has passed.

The intention is that it gives bookers a limited amount of time to pay
the booking (and thus the status changing to "Paid") before the offer
has expired.

It assumes custom fields `offer_expires` and `status` exists.

This plugin requires the [TIL Bookings](https://github.com/tobyink-bookings/booking-core) plugin.
