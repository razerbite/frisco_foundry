<ul class="process">
  <li class="{{{ Request::is("sales/quotations/*/request") ? 'active' : '' }}}">
    @if(Entrust::can('view_request') || isDirectAward($quotation->rfq_id))
      <a href="{{ route('quotations.request', ['rfq'=>Str::slug($quotation->rfq_id)]) }}">
        Request for Quotation
      </a>
    @else
      Request for Quotation
    @endif
  </li>
  <li class='{{{ Request::is("sales/quotations/*/bom") ? 'active' : '' }}}'>
    @if(Entrust::can('view_bom') || isDirectAward($quotation->rfq_id))
      <a href="{{ route('quotations.bom', ['rfq'=>Str::slug($quotation->rfq_id)]) }}">
        Bill of Materials
      </a>
    @else
      Bill of Materials
    @endif
  </li>
  <li class='{{{ Request::is("sales/quotations/*/approval") ? 'active' : '' }}}'>
    @if(Entrust::can('view_approval') || isDirectAward($quotation->rfq_id))
      <a href="{{ route('quotations.approval', ['rfq'=>Str::slug($quotation->rfq_id)]) }}">
        Executive Approval
      </a>
    @else
      Executive Approval
    @endif
  </li>
  <li class='{{{ Request::is("sales/quotations/*/summary") ? 'active' : '' }}}'>
    @if(Entrust::can('view_summary') || isDirectAward($quotation->rfq_id))
      <a href="{{ route('quotations.summary', ['rfq'=>Str::slug($quotation->rfq_id)]) }}">
        Summary
      </a>
    @else
      Summary
    @endif
  </li>
</ul>
