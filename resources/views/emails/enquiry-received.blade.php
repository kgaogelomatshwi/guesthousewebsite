<p>New enquiry received from {{ $enquiry->name }}.</p>
<p>Email: {{ $enquiry->email }}</p>
<p>Phone: {{ $enquiry->phone }}</p>
<p>Dates: {{ $enquiry->check_in }} - {{ $enquiry->check_out }}</p>
<p>Guests: {{ $enquiry->guests }}</p>
<p>Room: {{ $enquiry->room?->title ?? 'Any' }}</p>
<p>Message: {{ $enquiry->message }}</p>
