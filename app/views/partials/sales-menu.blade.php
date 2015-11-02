<nav id="main_menu">
  <ul>
    <li title="Sales & Marketing" class="{{{ Request::is("sales*") ? 'green' : '' }}}"><a href="{{ route('sales.index') }}"><img src="{{ asset('images/menu_sales.png') }}"></a>
      <ul>
        <li><a href="{{ route('sales.index') }}">Manage Quotations</a></li>
        <li><a href="{{ route('customers.index') }}">Manage Customers</a></li>
<!--         <li><a href="secretaries.html">Manage Secretaries</a></li>
        <li><a href="#">Manage Technical</a></li> -->
      </ul>
    </li>
    <li title="Production" class="{{{ Request::is("production*") ? 'green' : '' }}}"><a href="{{ route('production.index') }}"><img src="{{ asset('images/menu_production.png') }}"></a>
      <ul>
        <li><a href="{{ route('production.index') }}">View Job Orders</a></li>
        <li><a href="{{ route('production.submit_po') }}">Manage Purchase Orders</a></li>
        <li><a href="{{ route('production.index') }}">Project Plans</a></li>
      </ul>
    </li>
    <!-- <li title="Production"><a href="job-order.html"><img src="../images/menu_production.png"></a>
      <ul>
        <li><a href="add-job-order.html">Add Job Order</a></li>
      </ul>
    </li> -->
    <!-- <li title="Logistics"><a href="#"><img src="../images/menu_logistics.png"></a></li>
    <li title="Accounting"><a href="#"><img src="../images/menu_accounting.png"></a>
      <ul>
        <li><a href="lead-handler.html">Sub Menu 1</a></li>
        <li><a href="lead-handler.html">Sub Menu 2</a></li>
      </ul>
    </li> -->
    @if(Entrust::can('manage_users'))
    <li title="Admin Management" class="{{{ Request::is("admin*") ? 'green' : '' }}}"><a href="{{ route('users.index') }}"><img src="{{ asset('images/menu_customers.png') }}"></a>
      <ul>
        <li><a href="{{ route('users.create') }}">Add User</a></li>
        <li><a href="{{ route('role.permissions.edit') }}">Edit Role Permissions</a></li>
      </ul>
    </li>
    @endif
    <!-- <li title="Generate Reports"><a href="#"><img src="../images/menu_reports.png"></a></li> -->
  </ul>
</nav>
