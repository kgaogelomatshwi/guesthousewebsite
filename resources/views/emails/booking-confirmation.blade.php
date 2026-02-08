<p>Hi {{ $booking->guest_name }},</p>
<p>Thanks for your booking request. We have received your details and will confirm availability shortly.</p>
<p><strong>Dates:</strong> {{ $booking->check_in }} to {{ $booking->check_out }}</p>
<p><strong>Guests:</strong> {{ $booking->guests }}</p>
<p><strong>Booking code:</strong> {{ $booking->code }}</p>
<p>We look forward to hosting you in Limpopo.</p>
