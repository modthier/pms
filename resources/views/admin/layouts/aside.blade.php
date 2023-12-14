 <!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.html" class="app-brand-link">
             
              <span class="app-brand-text demo menu-text fw-bolder ms-2">KPMS</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item active">
              <a href="/" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <!-- Layouts -->

            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts"> {{ __('body.sales') }}</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{ route('DrugOrders.create') }}" class="menu-link">
                    <div data-i18n="Without menu"> {{ __('body.pointOfSale') }} </div>
                  </a>
                </li>

                 <li class="menu-item">
                  <a href="{{ route('insurancePointOfSale.create') }}" class="menu-link">
                    <div data-i18n="Without menu"> Insurance POS </div>
                  </a>
                </li>

              

               
               
              </ul>
            </li>

            @can('can_access')
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">{{ __('body.purchases') }}</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{ route('PurchaseOrders.index') }}" class="menu-link">
                    <div data-i18n="Without menu"> Purchase Orders </div>
                  </a>
                </li>
                
              </ul>
            </li>
            @endcan


            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts"> {{ __('body.drugs') }}</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{ route('drugs.index') }}" class="menu-link">
                    <div data-i18n="Without menu"> {{ __('body.drugList') }}  </div>
                  </a>
                </li>
                @can('can_access')
                <li class="menu-item">
                  <a href="{{ route('drugTypes.index') }}" class="menu-link">
                    <div data-i18n="Without menu"> {{ __('body.drugTypes') }}  </div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="{{ route('drugUnits.index') }}" class="menu-link">
                    <div data-i18n="Without menu">{{ __('body.drugUnits') }} </div>
                  </a>
                </li>
                @endcan
              </ul>
            </li>

            @can('can_access')
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">{{ __('body.stock') }}</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{ route('stocks.index') }}" class="menu-link">
                    <div data-i18n="Without menu"> {{ __('body.avalaibleStock') }}  </div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="{{ route('stocks.history') }}" class="menu-link">
                    <div data-i18n="Without menu"> {{ __('body.stockHistory') }}  </div>
                  </a>
                </li>


              </ul>
            </li>
            @endcan

            @can('can_access')
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">{{ __('body.staff') }}</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{ route('register.index') }}" class="menu-link">
                    <div data-i18n="Without menu"> {{ __('body.usersList') }} </div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="{{ route('Shifts.index') }}" class="menu-link">
                    <div data-i18n="Without menu"> {{ __('body.shifts') }} </div>
                  </a>
                </li>
              </ul>
            </li>
            @endcan


             <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">{{ __('body.reports') }}</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{ route('DrugRequests.index') }}" class="menu-link">
                    <div data-i18n="Without menu">{{ __('body.salesReport') }} </div>
                  </a>
                </li>
                @can('can_access')

                <li class="menu-item">
                  <a href="{{ route('DrugRequests.mostSold') }}" class="menu-link">
                    <div data-i18n="Without menu"> {{ __('body.mostSold') }}  </div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="{{ route('ReturnedItems.index') }}" class="menu-link">
                    <div data-i18n="Without menu"> {{ __('body.purchaseReturns') }} </div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="{{ route('Summary.index') }}" class="menu-link">
                    <div data-i18n="Without menu">{{ __('body.summaryReport') }} </div>
                  </a>
                </li>

                @endcan


              </ul>
            </li>

            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Insurance</div>
              </a>

              <ul class="menu-sub">
              @can('can_access')
              <li class="menu-item">
                  <a href="{{ route('insuranceCompany.index') }}" class="menu-link">
                    <div data-i18n="Without menu"> Insurance Companies </div>
                  </a>
                </li>

                
                <li class="menu-item">
                  <a href="{{ route('pos.InsuranceSalesReport') }}" class="menu-link">
                    <div data-i18n="Without menu"> Insurance Sales Report  </div>
                  </a>
                </li>


                <li class="menu-item">
                  <a href="{{ route('InsuranceInvoice.index') }}" class="menu-link">
                    <div data-i18n="Without menu"> Insurance Invoices  </div>
                  </a>
                </li>
                @endcan

                
                
              </ul>
            </li>

            @can('can_access')
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">{{ __('body.managePayments') }}</div>
              </a>

              <ul class="menu-sub">
              
              <li class="menu-item">
                  <a href="{{ route('accounts.index') }}" class="menu-link">
                    <div data-i18n="Without menu"> {{ __('body.bankAccounts') }} </div>
                  </a>
                </li>

                
                <li class="menu-item">
                  <a href="{{ route('payments.index') }}" class="menu-link">
                    <div data-i18n="Without menu"> {{ __('body.payments') }}  </div>
                  </a>
                </li>

              </ul>
            </li>
            @endcan


            
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">{{ __('body.directory') }}</div>
              </a>

              <ul class="menu-sub">
              
              <li class="menu-item">
                  <a href="{{ route('expense.index') }}" class="menu-link">
                    <div data-i18n="Without menu"> Expenses </div>
                  </a>
                </li>

                @can('can_access')
                <li class="menu-item">
                  <a href="{{ route('item.index') }}" class="menu-link">
                    <div data-i18n="Without menu"> Expense Items  </div>
                  </a>
                </li>


                <li class="menu-item">
                  <a href="{{ route('paymentMethod.index') }}" class="menu-link">
                    <div data-i18n="Without menu"> {{ __('body.paymentMethods') }}  </div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="{{ route('backup.index') }}" class="menu-link">
                    <div data-i18n="Without menu"> Backup  </div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="{{ route('setting.index') }}" class="menu-link">
                    <div data-i18n="Without menu"> {{ __('body.setting') }}  </div>
                  </a>
                </li>
                @endcan
              </ul>
            </li>



            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">{{ __('body.expiryManagement') }}</div>
              </a>

              <ul class="menu-sub">
              
              <li class="menu-item">
                  <a href="{{ route('drugs.expired') }}" class="menu-link">
                    <div data-i18n="Without menu"> {{ __('body.expiryReport') }} </div>
                  </a>
                </li>

                @can('can_access')
                <li class="menu-item">
                  <a href="{{ route('expiredStock.index') }}" class="menu-link">
                    <div data-i18n="Without menu"> {{ __('body.expiredStock') }}  </div>
                  </a>
                </li>
                @endcan
              </ul>
            </li>
            
          </ul>
</aside>
        <!-- / Menu -->