<?php

Auth::routes(['verify' => true, 'register' => false]);

Route::middleware(['auth', 'verified'])->group(
    function () {
        Route::redirect('/dashboard', url('/'));
        Route::redirect('/password/confirm', url('/'));
        Route::get('/', 'DashboardController@index')->name('dashboard');

        Route::namespace('Transaction')->group(function () {
            Route::middleware('permission:view-transaction')->group(function () {
                Route::resource('patient', 'PatientController');
                Route::post('/patient/data', 'PatientController@data')->name('patient.data');
                Route::resource('receipt', 'ReceiptController');
                Route::post('/receipt/data', 'ReceiptController@data')->name('receipt.data');
                Route::get('/receipt/create/medical', 'ReceiptController@create')->name('receipt.create.medical');
                Route::get('/receipt/create/medicine', 'ReceiptController@create')->name('receipt.create.medicine');
                Route::resource('payment', 'PaymentController');
                Route::post('/payment/data', 'PaymentController@data')->name('payment.data');
                Route::get('/payment/create/item', 'PaymentController@create')->name('payment.create.item');
                Route::get('/payment/create/doctor', 'PaymentController@create')->name('payment.create.doctor');
                Route::resource('journal', 'JournalEntryController');
                Route::post('/journal/data', 'JournalEntryController@data')->name('journal.data');
                Route::resource('cash', 'CashBankController');
                Route::post('/cash/data', 'CashBankController@data')->name('cash.data');
            });
        });

        Route::namespace('Report')->group(function () {
            Route::middleware('permission:view-report')->group(function () {
                Route::get('/general-ledger', 'GeneralLedgerController@index')->name('general-ledger.index');
                Route::get('/income-statement', 'IncomeStatementController@index')->name('income-statement.index');
                Route::get('/balance-sheet', 'BalanceSheetController@index')->name('balance-sheet.index');
                Route::get('/trial-balance', 'TrialBalanceController@index')->name('trial-balance.index');
                Route::get('/cash-flow', 'CashFlowController@index')->name('cash-flow.index');
            });
        });

        Route::namespace('User')->group(
            function () {
                Route::prefix('/password')->as('password.')->group(
                    function () {
                        Route::get('/edit', 'ChangePasswordController@edit')->name('edit');
                        Route::post('/', 'ChangePasswordController@update')->name('store');
                    }
                );
                Route::middleware('permission:view-role')->group(
                    function () {
                        Route::resource('role', 'RoleController')->except(['destroy']);
                        Route::post('/role/data', 'RoleController@data')->name('role.data');
                    }
                );
                Route::middleware('permission:view-user')->group(
                    function () {
                        Route::resource('user', 'UserController');
                        Route::post('/user/data', 'UserController@data')->name('user.data');
                        Route::post('/user/bulk', 'UserController@bulk')->name('user.bulk');
                    }
                );
            }
        );

        Route::prefix('/master')->as('master.')->namespace('Master')->group(
            function () {
                Route::middleware('permission:view-master')->group(
                    function () {
                        Route::resource('company', 'CompanyController')->except(['show']);

                        Route::resource('unit', 'UnitController')->except(['show']);
                        Route::post('/unit/data', 'UnitController@data')->name('unit.data');

                        Route::resource('account', 'AccountController')->except(['show']);
                        Route::post('/account/data', 'AccountController@data')->name('account.data');

                        Route::resource('item', 'ItemController')->except(['show']);
                        Route::post('/item/data', 'ItemController@data')->name('item.data');

                        Route::resource('fiscal-year', 'FiscalYearController')->except(['show']);
                        Route::post('/fiscal-year/data', 'FiscalYearController@data')->name('fiscal-year.data');

                        Route::resource('patient', 'PatientController')->except(['show']);
                        Route::post('/patient/data', 'PatientController@data')->name('patient.data');

                        Route::resource('specialty', 'SpecialtyController')->except(['show']);
                        Route::post('/specialty/data', 'SpecialtyController@data')->name('specialty.data');

                        Route::resource('doctor', 'DoctorController')->except(['show']);
                        Route::post('/doctor/data', 'DoctorController@data')->name('doctor.data');

                        Route::resource('service', 'ServiceController')->except(['show']);
                        Route::post('/service/data', 'ServiceController@data')->name('service.data');

                        Route::resource('supplier', 'SupplierController')->except(['show']);
                        Route::post('/supplier/data', 'SupplierController@data')->name('supplier.data');
                    }
                );

            }
        );
    }
);