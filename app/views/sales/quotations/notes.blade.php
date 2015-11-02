<section class="information">
  <p><b>Note History</b></p>
  @if(!$quotation->notes->isEmpty())
    <table class="table"><!--This is table-->
      <th>Description</th>
      <th>Date of Entry</th>
      <th>User Account</th>
      @foreach($quotation->notes as $note)
      <tr>
        <td>{{ nl2br($note->notes) }}</td>
        <td>{{ Carbon::parse($note->created_at)->toDayDateTimeString() }}</td>
        <td>{{{ $note->author->full_name or 'User not found' }}}</td>
      </tr>
      @endforeach
    </table>
  @else
    <div class="alert alert-warning">No notes</div>
  @endif
</section>
