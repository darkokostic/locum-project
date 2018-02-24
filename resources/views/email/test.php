
<main>
	<table>
		<thead>
		<tr>
			<th class="service">JOB TITLE</th>
			<th class="desc">DESCRIPTION</th>
			
			@if($job->day_rate != 0)
			<th>DAY RATE</th>
			@else
			<th>Percentage RATE</th>
			@endif
			<th>DAYS</th>
			<th>TOTAL</th>
		</tr>
		</thead>
		<tbody>
		@foreach ($jobs as $job)
		<tr>
			<td class="service">{{ $job->title }}</td>
			<td class="desc">{{ $job->desc }}</td>
			
			@if($job->day_rate != 0)
			<td class="unit">${{$job->day_rate}}</td>
			@else
			<td class="unit">${{$job->percentage}}</td>
			@endif
			<td class="qty">{{$job->days}}</td>
			@if($job->day_rate != 0)
			<td class="total">${{$job->day_rate * $job->days}}</td>
			@else
			<td>{{$job->current_income}}</td>
			@endif
		</tr>
		@endforeach
		<tr>
			<td colspan="4">GRAND TOTAL</td>
			<td class="total">${{$total}}</td>
		</tr>
		</tbody>
	</table>
</main>
<footer>
	Invoice was created on a computer and is valid without the signature and seal.
</footer>
</body>
</html>