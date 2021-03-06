<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">
            <ul class="mainnav">
                <li class="{{ set_active('/') }}">
                    <a href="/">
                        <i class="icon-home"></i>
                        <span>Home</span> 
                    </a> 
                </li>
                <li class="{{ set_active('sales/registrar') }}">
                    <a target="_blank" href="/sales">
                        <i class="icon-tag"></i>
                        <span>Sales Register</span> 
                    </a> 
                </li>
                <li class="{{ set_active('items') }}">
                    <a href="/items">
                        <i class="icon-gift"></i>
                        <span>Items</span> 
                    </a> 
                </li>
                <li class="{{ set_active('inventory') }}">
                    <a href="/inventory">
                        <i class="icon-lock"></i>
                        <span>Inventory</span> 
                    </a>
                </li>
                <li class="{{ set_active('transactions/shipments') }}">
                    <a href="/transactions/shipments/">
                        <i class="icon-truck"></i>
                        <span>Shipments</span> 
                    </a> 
                </li>
                <li class="{{ set_active('customers') }}">
                    <a href="/customers">
                        <i class="icon-group"></i><span>Customers</span> 
                    </a> 
                </li>

                <li class="{{ set_active('employees') }}">
                    <a href="/employees/">
                        <i class="icon-truck"></i>
                        <span>Employees</span> 
                    </a> 
                </li>

                <li class="{{ set_active('suppliers') }}">
                    <a href="/suppliers">
                        <i class="icon-briefcase"></i><span>Vendors</span> 
                    </a> 
                </li>



                <li class="{{ set_active('reports') }}">
                    <a href="/reports">
                        <i class="icon-bar-chart"></i>
                        <span>Reports</span> 
                    </a> 
                </li>
                <li class="{{ set_active('settings') }}">
                    <a href="/settings/">
                        <i class="icon-cog"></i><span>Settings</span>
                    </a> 
                </li>
                
                <!-- <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-cog"></i><span>Settings</span> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/categories">Categories</a></li>
                        <li><a href="/flavors">Flavors</a></li>
                        <li><a href="/coupuns">Store Coupons</a></li>
                        <li><a href="/suppliers">Suppliers</a></li>

                    </ul>
                </li> -->
            </ul>
        </div>
    </div>
</div>