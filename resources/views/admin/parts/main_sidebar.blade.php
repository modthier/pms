<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img  src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
      <span class="brand-text font-weight-light">KPMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('vendor/adminlte/dist/img/avatar5.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth()->user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <a href="/" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                {{ __('body.dash') }}
              </p>
            </a>
          </li>


          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-search-dollar "></i>
              <p>
                {{ __('body.sales') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('DrugOrders.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('body.pointOfSale') }}</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('insurancePointOfSale.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Insurance POS</p>
                </a>
              </li>
              
              

            </ul>
          </li>


          
           @can('can_access')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money-check-alt"></i>
              <p>
                {{ __('body.purchases') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
               <li class="nav-item">
                <a href="{{ route('PurchaseOrders.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Orders</p>
                </a>
              </li>
              
            </ul>
          </li>
          @endcan

          
           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-capsules"></i>
              <p>
                {{ __('body.drugs') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('drugs.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('body.drugList') }}</p>
                </a>
              </li>
               @can('can_access')
              
             
              <li class="nav-item">
                <a href="{{ route('drugTypes.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('body.drugTypes') }}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('drugUnits.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('body.drugUnits') }}</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          


          @can('can_access')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-store"></i>
              <p>
                {{ __('body.stock') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('stocks.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('body.avalaibleStock') }}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('stocks.history') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('body.stockHistory') }}</p>
                </a>
              </li>
            
            </ul>
          </li>
          @endcan



          
          
          

          @can('can_access')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-address-card"></i>
              <p>
                {{ __('body.staff') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('register.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('body.usersList') }}</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('Shifts.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('body.shifts') }}</p>
                </a>
              </li>


            </ul>
          </li>
          @endcan


          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-file-alt"></i>
              <p>
                {{ __('body.reports') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('DrugRequests.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('body.salesReport') }}</p>
                </a>

                @can('can_access')
                 <a href="{{ route('DrugRequests.mostSold') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p></p>
                </a>


                <a href="{{ route('ReturnedItems.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('body.purchaseReturns') }}</p>
                </a>

                <a href="{{ route('Summary.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('body.summaryReport') }}</p>
                </a>

                @endcan
              </li>
            </ul>
          </li>

          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-life-ring"></i>
              <p>
                Insurance
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('can_access')
              <li class="nav-item">
                <a href="{{ route('insuranceCompany.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Insurance Companies</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('pos.InsuranceSalesReport') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Insurance Sales Report</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('InsuranceInvoice.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Insurance Invoices</p>
                </a>
              </li>

              

              
              @endcan
               
            </ul>
          </li>
          
         


          @can('can_access')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-money-bill"></i>
              <p>
               {{ __('body.managePayments') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="{{ route('accounts.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('body.bankAccounts') }}</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('payments.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('body.payments') }}</p>
                </a>
              </li>

            </ul>
          </li>
          @endcan


          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-folder"></i>
              <p>
                {{ __('body.directory') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="{{ route('expense.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Expenses</p>
                </a>
                @can('can_access')

               
                <a href="{{ route('paymentMethod.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __('body.paymentMethods') }}</p>
                </a>
[
                <a href="{{ route('item.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Expense Items</p>
                </a>

                <a href="{{ route('backup.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Backup</p>
                </a>

                

                <a href="{{ route('setting.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('body.setting') }}</p>
                </a>

                @endcan
              </li>
            </ul>
          </li>
          


          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon  fas fa-exclamation-triangle" style="color: red;"></i>
              <p>
                {{ __('body.expiryManagement') }}
                <i class="fas fa-angle-left  right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="{{ route('drugs.expired') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('body.expiryReport') }}</p>
                </a>
                @can('can_access')
                 <a href="{{ route('expiredStock.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('body.expiredStock') }}</p>
                </a>

                @endcan                
              </li>
            </ul>
          </li>
          

          

          

          


         

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
