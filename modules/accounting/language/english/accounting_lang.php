<?php 

$lang['als_accounting'] = 'Accounting';
$lang['transaction'] = 'Transactions';
$lang['journal_entry'] = 'Journal Entry';
$lang['transfer'] = 'Transfer';
$lang['chart_of_accounts'] = 'Chart of Accounts';
$lang['reconcile'] = 'Reconcile';
$lang['banking'] = 'Banking';
$lang['sales'] = 'Sales';
$lang['first_month_of_financial_year'] = 'First month of financial year';
$lang['first_month_of_tax_year'] = 'First month of tax year';
$lang['accounting_method'] = 'Accounting method';
$lang['same_as_financial_year'] = 'Same as financial year';
$lang['accrual'] = 'Accrual';
$lang['close_the_books '] = 'Close the books ';
$lang['accrual'] = 'Accrual';
$lang['allow_changes_after_viewing_a_warning'] = 'Allow changes after viewing a warning';
$lang['allow_changes_after_viewing_a_warning_and_password'] = 'Allow changes after viewing a warning and entering password';
$lang['enable_account_numbers'] = 'Enable account numbers';
$lang['show_account_numbers'] = 'Show account numbers';
$lang['close_the_books'] = 'Close the books';
$lang['first_month_of_financial_year_note'] = 'For reporting, you can specify any month as the start of your financial year (also called your financial reporting year or accounting year).';
$lang['accounting_method_note'] = 'Choose Accrual to report income when you bill a customer; choose Cash to report income when you receive payment from a customer. If you are not sure, consult your accountant.';
$lang['close_the_books_note'] = 'Prevents any changes to transactions dated earlier than the closing date.';
$lang['chart_of_accounts_note'] = 'Turns on the use of account numbers in your Chart of Accounts. This affects all users within your company.';
$lang['show_account_numbers_note'] = 'Displays account numbers on reports and transactions, such as in sales and expense forms (for your view only).';
$lang['closing_date'] = 'Closing date';

// Account type
$lang['acc_accounts_receivable'] = 'Accounts Receivable (A/R)';
$lang['acc_accounts_receivable_note'] = 'Accounts receivable (also called A/R, Debtors, or Trade and other receivables) tracks money that customers owe you for products or services, and payments customers make.

Each customer has a register, which functions like an Accounts receivable account for each customer.';
$lang['acc_current_assets'] = 'Current assets';
$lang['acc_allowance_for_bad_debts'] = 'Allowance for bad debts';
$lang['acc_allowance_for_bad_debts_note'] = 'Use Allowance for bad debts to estimate the part of Accounts Receivable that you think you might not collect.
Use this only if you are keeping your books on the accrual basis.';
$lang['acc_assets_available_for_sale'] = 'Assets available for sale';
$lang['acc_assets_available_for_sale_note'] = 'Use Assets available for sale to track assets that are available for sale that are not expected to be held for a long period of time.';
$lang['acc_development_costs'] = 'Development Costs';
$lang['acc_development_costs_note'] = 'Use Development costs to track amounts you deposit or set aside to arrange for financing, such as an SBA loan, or for deposits in anticipation of the purchase of property or other assets.
When the deposit is refunded, or the purchase takes place, remove the amount from this account.';
$lang['acc_employee_cash_advances'] = 'Employee Cash Advances';
$lang['acc_employee_cash_advances_note'] = 'Use Employee cash advances to track employee wages and salary you issue to an employee early, or other non-salary money given to employees.
If you make a loan to an employee, use the Current asset account type called Loans to others, instead.';
$lang['acc_inventory'] = 'Inventory';
$lang['acc_inventory_note'] = 'Use Inventory to track the cost of goods your business purchases for resale.
When the goods are sold, assign the sale to a Cost of sales account.';
$lang['acc_investments_other'] = 'Investments - Other';
$lang['acc_investments_other_note'] = 'Use Investments - Other to track the value of investments not covered by other investment account types. Examples include publicly-traded shares, coins, or gold.';
$lang['acc_loans_to_officers'] = 'Loans To Officers';
$lang['acc_loans_to_officers_note'] = 'If you operate your business as a Corporation, use Loans to officers to track money loaned to officers of your business.';
$lang['acc_loans_to_others'] = 'Loans To Others';
$lang['acc_loans_to_others_note'] = 'Use Loans to others to track money your business loans to other people or businesses.
This type of account is also referred to as Notes Receivable.

For early salary payments to employees, use Employee cash advances, instead.';
$lang['acc_loans_to_shareholders'] = 'Loans To Shareholders';
$lang['acc_loans_to_shareholders_note'] = 'If you operate your business as a Corporation, use Loans to Shareholders to track money your business loans to its shareholders.';
$lang['acc_other_current_assets'] = 'Other current assets';
$lang['acc_other_current_assets_note'] = 'Use Other current assets for current assets not covered by the other types. Current assets are likely to be converted to cash or used up in a year.';
$lang['acc_prepaid_expenses'] = 'Prepaid Expenses';
$lang['acc_prepaid_expenses_note'] = 'Use Prepaid expenses to track payments for expenses that you won’t recognise until your next accounting period.
When you recognise the expense, make a journal entry to transfer money from this account to the expense account.';
$lang['acc_retainage'] = 'Retainage';
$lang['acc_retainage_note'] = 'Use Retainage if your customers regularly hold back a portion of a contract amount until you have completed a project.
This type of account is often used in the construction industry, and only if you record income on an accrual basis.';
$lang['acc_undeposited_funds'] = 'Undeposited Funds';
$lang['acc_undeposited_funds_note'] = 'Use Undeposited funds for cash or cheques from sales that haven’t been deposited yet.
For petty cash, use Cash on hand, instead.';
$lang['acc_bank'] = 'Bank';
$lang['acc_bank_note'] = 'Use Bank accounts to track all your current activity, including debit card transactions.';
$lang['acc_cash_and_cash_equivalents'] = 'Cash and cash equivalents';
$lang['acc_cash_and_cash_equivalents_note'] = 'Use Cash and Cash Equivalents to track cash or assets that can be converted into cash immediately. For example, marketable securities and Treasury bills.';
$lang['acc_cash_on_hand'] = 'Cash on hand';
$lang['acc_cash_on_hand_note'] = 'Use a Cash on hand account to track cash your company keeps for occasional expenses, also called petty cash.
To track cash from sales that have not been deposited yet, use a pre-created account called Undeposited funds, instead.';
$lang['acc_client_trust_account'] = 'Client trust account';
$lang['acc_client_trust_account_note'] = 'Use Client trust accounts for money held by you for the benefit of someone else.
For example, trust accounts are often used by attorneys to keep track of expense money their customers have given them.

Often, to keep the amount in a trust account from looking like it’s yours, the amount is offset in a "contra" liability account (a Current Liability).';
$lang['acc_money_market'] = 'Money Market';
$lang['acc_money_market_note'] = 'Use Money market to track amounts in money market accounts.
For investments, see Current Assets, instead.';
$lang['acc_rents_held_in_trust'] = 'Rents Held in Trust';
$lang['acc_rents_held_in_trust_note'] = 'Use Rents held in trust to track deposits and rent held on behalf of the property owners.
Typically only property managers use this type of account.';
$lang['acc_savings'] = 'Savings';
$lang['acc_savings_note'] = 'Use Savings accounts to track your savings and CD activity.
Each savings account your company has at a bank or other financial institution should have its own Savings type account.

For investments, see Current Assets, instead.';
$lang['acc_accumulated_depletion'] = 'Accumulated depletion';
$lang['acc_accumulated_depletion_note'] = 'Use Accumulated depletion to track how much you deplete a natural resource.';
$lang['acc_accumulated_depreciation_on_property_plant_and_equipment'] = 'Accumulated depreciation on property, plant and equipment';
$lang['acc_accumulated_depreciation_on_property_plant_and_equipment_note'] = 'Use Accumulated depreciation on property, plant and equipment to track how much you depreciate a fixed asset (a physical asset you do not expect to convert to cash during one year of normal operations).';
$lang['acc_buildings'] = 'Buildings';
$lang['acc_buildings_note'] = 'Use Buildings to track the cost of structures you own and use for your business. If you have a business in your home, consult your accountant.
Use a Land account for the land portion of any real property you own, splitting the cost of the property between land and building in a logical method. A common method is to mimic the land-to-building ratio on the property tax statement.';
$lang['acc_depletable_assets'] = 'Depletable Assets';
$lang['acc_depletable_assets_note'] = 'Use Depletable assets to track natural resources, such as timberlands, oil wells, and mineral deposits.';
$lang['acc_furniture_and_fixtures'] = 'Furniture and Fixtures';
$lang['acc_furniture_and_fixtures_note'] = 'Use Furniture and fixtures to track any furniture and fixtures your business owns and uses, like a dental chair or sales booth.';
$lang['acc_land'] = 'Land';
$lang['acc_land_note'] = 'Use Land to track assets that are not easily convertible to cash or not expected to become cash within the next year. For example, leasehold improvements.';
$lang['acc_leasehold_improvements'] = 'Leasehold Improvements';
$lang['acc_leasehold_improvements_note'] = 'Use Leasehold improvements to track improvements to a leased asset that increases the asset’s value. For example, if you carpet a leased office space and are not reimbursed, that’s a leasehold improvement.';
$lang['acc_machinery_and_equipment'] = 'Machinery and equipment';
$lang['acc_machinery_and_equipment_note'] = 'Use Machinery and equipment to track computer hardware, as well as any other non-furniture fixtures or devices owned and used for your business.
This includes equipment that you ride, like tractors and lawn mowers. Cars and lorries, however, should be tracked with Vehicle accounts, instead.';
$lang['acc_other_fixed_assets'] = 'Other fixed assets';
$lang['acc_other_fixed_assets_note'] = 'Use Other fixed asset for fixed assets that are not covered by other asset types.
Fixed assets are physical property that you use in your business and that you do not expect to convert to cash or be used up during one year of normal operations.';
$lang['acc_vehicles'] = 'Vehicles';
$lang['acc_vehicles_note'] = 'Use Vehicles to track the value of vehicles your business owns and uses for business. This includes off-road vehicles, air planes, helicopters, and boats.
If you use a vehicle for both business and personal use, consult your accountant to see how you should track its value.';
$lang['acc_accumulated_amortisation_of_non_current_assets'] = 'Accumulated amortisation of non-current assets';
$lang['acc_accumulated_amortisation_of_non_current_assets_note'] = 'Use Accumulated amortisation of non-current assets to track how much you’ve amortised an asset whose type is Non-Current Asset.';
$lang['acc_assets_held_for_sale'] = 'Assets held for sale';
$lang['acc_assets_held_for_sale_note'] = 'Use Assets held for sale to track assets of a company that are available for sale that are not expected to be held for a long period of time.';
$lang['acc_deferred_tax'] = 'Deferred tax';
$lang['acc_deferred_tax_note'] = 'Use Deferred tax for tax liabilities or assets that are to be used in future accounting periods.';
$lang['acc_goodwill'] = 'Goodwill';
$lang['acc_goodwill_note'] = 'Use Goodwill only if you have acquired another company. It represents the intangible assets of the acquired company which gave it an advantage, such as favourable government relations, business name, outstanding credit ratings, location, superior management, customer lists, product quality, or good labour relations.';
$lang['acc_intangible_assets'] = 'Intangible Assets';
$lang['acc_intangible_assets_note'] = 'Use Intangible assets to track intangible assets that you plan to amortise. Examples include franchises, customer lists, copyrights, and patents.';
$lang['acc_lease_buyout'] = 'Lease Buyout';
$lang['acc_lease_buyout_note'] = 'Use Lease buyout to track lease payments to be applied toward the purchase of a leased asset.
You don’t track the leased asset itself until you purchase it.';
$lang['acc_licences'] = 'Licences';
$lang['acc_licences_note'] = 'Use Licences to track non-professional licences for permission to engage in an activity, like selling alcohol or radio broadcasting.
For fees associated with professional licences granted to individuals, use a Legal and professional fees expense account, instead.';
$lang['acc_long_term_investments'] = 'Long-term investments';
$lang['acc_long_term_investments_note'] = 'Use Long-term investments to track investments that have a maturity date of longer than one year.';
$lang['acc_organisational_costs'] = 'Organisational Costs';
$lang['acc_organisational_costs_note'] = 'Use Organisational costs to track costs incurred when forming a partnership or corporation.
The costs include the legal and accounting costs necessary to organise the company, facilitate the filings of the legal documents, and other paperwork.';
$lang['acc_other_non_current_assets'] = 'Other non-current assets';
$lang['acc_other_non_current_assets_note'] = 'Use Other non-current assets to track assets not covered by other types.
Non-current assets are long-term assets that are expected to provide value for more than one year.';
$lang['acc_security_deposits'] = 'Security Deposits';
$lang['acc_security_deposits_note'] = 'Use Security deposits to track funds you’ve paid to cover any potential costs incurred by damage, loss, or theft.
The funds should be returned to you at the end of the contract.

If you accept down payments, advance payments, security deposits, or other kinds of deposits, use an Other Current liabilities account with the detail type Other Current liabilities.';
$lang['acc_accounts_payable'] = 'Accounts Payable (A/P)';
$lang['acc_accounts_payable_note'] = 'Accounts payable (also called A/P, Trade and other payables, or Creditors) tracks amounts you owe to your suppliers.';
$lang['acc_credit_card'] = 'Credit Card';
$lang['acc_credit_card_note'] = 'Credit card accounts track the balance due on your business credit cards.
Create one Credit card account for each credit card account your business uses.';
$lang['acc_accrued_liabilities'] = 'Accrued liabilities';
$lang['acc_accrued_liabilities_note'] = 'Use Accrued Liabilities to track expenses that a business has incurred but has not yet paid. For example, pensions for companies that contribute to a pension fund for their employees for their retirement.';
$lang['acc_client_trust_accounts_liabilities'] = 'Client Trust Accounts - Liabilities';
$lang['acc_client_trust_accounts_liabilities_note'] = 'Use Client Trust accounts - liabilities to offset Client Trust accounts in assets.
Amounts in these accounts are held by your business on behalf of others. They do not belong to your business, so should not appear to be yours on your balance sheet. This "contra" account takes care of that, as long as the two balances match.';
$lang['acc_current_tax_liability'] = 'Current Tax Liability';
$lang['acc_current_tax_liability_note'] = 'Use Current tax liability to track the total amount of taxes collected but not yet paid to the government.';
$lang['acc_current_portion_of_obligations_under_finance_leases'] = 'Current portion of obligations under finance leases';
$lang['acc_current_portion_of_obligations_under_finance_leases_note'] = 'Use Current portion of obligations under finance leases to track the value of lease payments due within the next 12 months.';
$lang['acc_dividends_payable'] = 'Dividends payable';
$lang['acc_dividends_payable_note'] = 'Use Dividends payable to track dividends that are owed to shareholders but have not yet been paid.';
$lang['acc_income_tax_payable'] = 'Income tax payable';
$lang['acc_income_tax_payable_note'] = 'Use Income tax payable to track monies that are due to pay the company’s income tax liabilties.';
$lang['acc_insurance_payable'] = 'Insurance payable';
$lang['acc_insurance_payable_note'] = 'Use Insurance payable to keep track of insurance amounts due.
This account is most useful for businesses with monthly recurring insurance expenses.';
$lang['acc_line_of_credit'] = 'Line of Credit';
$lang['acc_line_of_credit_note'] = 'Use Line of credit to track the balance due on any lines of credit your business has. Each line of credit your business has should have its own Line of credit account.';
$lang['acc_loan_payable'] = 'Loan Payable';
$lang['acc_loan_payable_note'] = 'Use Loan payable to track loans your business owes which are payable within the next twelve months.
For longer-term loans, use the Long-term liability called Notes payable, instead.';
$lang['acc_other_current_liabilities'] = 'Other current liabilities';
$lang['acc_other_current_liabilities_note'] = 'Use Other current liabilities to track monies owed by the company and due within one year.';
$lang['acc_payroll_clearing'] = 'Payroll Clearing';
$lang['acc_payroll_clearing_note'] = 'Use Payroll clearing to keep track of any non-tax amounts that you have deducted from employee paycheques or that you owe as a result of doing payroll. When you forward money to the appropriate suppliers, deduct the amount from the balance of this account.
Do not use this account for tax amounts you have withheld or owe from paying employee wages. For those amounts, use the Payroll tax payable account instead.';
$lang['acc_payroll_liabilities'] = 'Payroll liabilities';
$lang['acc_payroll_liabilities_note'] = 'Use Payroll liabilities to keep track of tax amounts that you owe to government agencies as a result of paying wages. This includes taxes withheld, health care premiums, employment insurance, government pensions, etc. When you forward the money to the government agency, deduct the amount from the balance of this account.';
$lang['acc_prepaid_expenses_payable'] = 'Prepaid Expenses Payable';
$lang['acc_prepaid_expenses_payable_note'] = 'Use Prepaid expenses payable to track items such as property taxes that are due, but not yet deductible as an expense because the period they cover has not yet passed.';
$lang['acc_rents_in_trust_liability'] = 'Rents in trust - Liability';
$lang['acc_rents_in_trust_liability_note'] = 'Use Rents in trust - liability to offset the Rents in trust amount in assets.
Amounts in these accounts are held by your business on behalf of others. They do not belong to your business, so should not appear to be yours on your balance sheet. This "contra" account takes care of that, as long as the two balances match.';
$lang['acc_sales_and_service_tax_payable'] = 'Sales and service tax payable';
$lang['acc_sales_and_service_tax_payable_note'] = 'Use Sales and service tax payable to track tax you have collected, but not yet remitted to your government tax agency. This includes value-added tax, goods and services tax, sales tax, and other consumption tax.';
$lang['acc_accrued_holiday_payable'] = 'Accrued holiday payable';
$lang['acc_accrued_holiday_payable_note'] = 'Use Accrued holiday payable to track holiday earned but that has not been paid out to employees.';
$lang['acc_accrued_non_current_liabilities'] = 'Accrued non-current liabilities';
$lang['acc_accrued_non_current_liabilities_note'] = 'Use Accrued Non-current liabilities to track expenses that a business has incurred but has not yet paid. For example, pensions for companies that contribute to a pension fund for their employees for their retirement.';
$lang['acc_liabilities_related_to_assets_held_for_sale'] = 'Liabilities related to assets held for sale';
$lang['acc_liabilities_related_to_assets_held_for_sale_note'] = 'Use Liabilities related to assets held for sale to track any liabilities that are directly related to assets being sold or written off.';
$lang['acc_long_term_debt'] = 'Long-term debt';
$lang['acc_long_term_debt_note'] = 'Use Long-term debt to track loans and obligations with a maturity of longer than one year. For example, mortgages.';
$lang['acc_notes_payable'] = 'Notes Payable';
$lang['acc_notes_payable_note'] = 'Use Notes payable to track the amounts your business owes in long-term (over twelve months) loans.
For shorter loans, use the Current liability account type called Loan payable, instead.';
$lang['acc_other_non_current_liabilities'] = 'Other non-current liabilities';
$lang['acc_other_non_current_liabilities_note'] = 'Use Other non-current liabilities to track liabilities due in more than twelve months that don’t fit the other Non-Current liability account types.';
$lang['acc_shareholder_potes_payable'] = 'Shareholder Notes Payable';
$lang['acc_shareholder_potes_payable_note'] = 'Use Shareholder notes payable to track long-term loan balances your business owes its shareholders.';
$lang['acc_accumulated_adjustment'] = 'Accumulated adjustment';
$lang['acc_accumulated_adjustment_note'] = 'Some corporations use this account to track adjustments to owner’s equity that are not attributable to net income.';
$lang['acc_dividend_disbursed'] = 'Dividend disbursed';
$lang['acc_dividend_disbursed_note'] = 'Use Dividend disbursed to track a payment given to its shareholders out of the company’s retained earnings.';
$lang['acc_equity_in_earnings_of_subsidiaries'] = 'Equity in earnings of subsidiaries';
$lang['acc_equity_in_earnings_of_subsidiaries_note'] = 'Use Equity in earnings of subsidiaries to track the original investment in shares of subsidiaries plus the share of earnings or losses from the operations of the subsidiary.';
$lang['acc_opening_balance_equity'] = 'Opening Balance Equity';
$lang['acc_opening_balance_equity_note'] = 'As you enter opening balances, System records the amounts in Opening balance equity. This ensures that you have a correct balance sheet for your company, even before you’ve finished entering all your company’s assets and liabilities.';
$lang['acc_ordinary_shares'] = 'Ordinary shares';
$lang['acc_ordinary_shares_note'] = 'Corporations use Ordinary shares to track its ordinary shares in the hands of shareholders. The amount in this account should be the stated (or par) value of the stock.';
$lang['acc_other_comprehensive_income'] = 'Other comprehensive income';
$lang['acc_other_comprehensive_income_note'] = 'Use Other comprehensive income to track the increases or decreases in income from various businesses that is not yet absorbed by the company.';
$lang['acc_owner_equity'] = 'Owner\'s Equity';
$lang['acc_owner_equity_note'] = 'Corporations use Owner’s equity to show the cumulative net income or loss of their business as of the beginning of the financial year.';
$lang['acc_paid_in_capital_or_surplus'] = 'Paid-in capital or surplus';
$lang['acc_paid_in_capital_or_surplus_note'] = 'Corporations use Paid-in capital to track amounts received from shareholders in exchange for shares that are over and above the shares’ stated (or par) value.';
$lang['acc_partner_contributions'] = 'Partner Contributions';
$lang['acc_partner_contributions_note'] = 'Partnerships use Partner contributions to track amounts partners contribute to the partnership during the year.';
$lang['acc_partner_distributions'] = 'Partner Distributions';
$lang['acc_partner_distributions_note'] = 'Partnerships use Partner distributions to track amounts distributed by the partnership to its partners during the year.
Don’t use this for regular payments to partners for interest or service. For regular payments, use a Guaranteed payments account (a Expense account in Payroll expenses), instead.';
$lang['acc_partner_equity'] = 'Partner\'s Equity';
$lang['acc_partner_equity_note'] = 'Partnerships use Partner’s equity to show the income remaining in the partnership for each partner as of the end of the prior year.';
$lang['acc_preferred_shares'] = 'Preferred shares';
$lang['acc_preferred_shares_note'] = 'Corporations use this account to track its preferred shares in the hands of shareholders. The amount in this account should be the stated (or par) value of the shares.';
$lang['acc_retained_earnings'] = 'Retained Earnings';
$lang['acc_retained_earnings_note'] = 'Retained earnings tracks net income from previous financial years.';
$lang['acc_share_capital'] = 'Share capital';
$lang['acc_share_capital_note'] = 'Use Share capital to track the funds raised by issuing shares.';
$lang['acc_treasury_shares'] = 'Treasury Shares';
$lang['acc_treasury_shares_note'] = 'Corporations use Treasury shares to track amounts paid by the corporation to buy its own shares back from shareholders.';
$lang['acc_discounts_refunds_given'] = 'Discounts/Refunds Given';
$lang['acc_discounts_refunds_given_note'] = 'Use Discounts/refunds given to track discounts you give to customers.
This account typically has a negative balance so it offsets other income.

For discounts from suppliers, use an expense account, instead.';
$lang['acc_non_profit_income'] = 'Non-Profit Income';
$lang['acc_non_profit_income_note'] = 'Use Non-profit income to track money coming in if you are a non-profit organisation.';
$lang['acc_other_primary_income'] = 'Other Primary Income';
$lang['acc_other_primary_income_note'] = 'Use Other primary income to track income from normal business operations that doesn’t fall into another Income type.';
$lang['acc_revenue_general'] = 'Revenue - General';
$lang['acc_revenue_general_note'] = 'Use Revenue - General to track income from normal business operations that do not fit under any other category.';
$lang['acc_sales_retail'] = 'Sales - retail';
$lang['acc_sales_retail_note'] = 'Use Sales - retail to track sales of goods/services that have a mark-up cost to consumers.';
$lang['acc_sales_wholesale'] = 'Sales - wholesale';
$lang['acc_sales_wholesale_note'] = 'Use Sales - wholesale to track the sale of goods in quantity for resale purposes.';
$lang['acc_sales_of_product_income'] = 'Sales of Product Income';
$lang['acc_sales_of_product_income_note'] = 'Use Sales of product income to track income from selling products.
This can include all kinds of products, like crops and livestock, rental fees, performances, and food served.';
$lang['acc_service_fee_income'] = 'Service/Fee Income';
$lang['acc_service_fee_income_note'] = 'Use Service/fee income to track income from services you perform or ordinary usage fees you charge.
For fees customers pay you for late payments or other uncommon situations, use an Other Income account type called Other miscellaneous income, instead.';
$lang['acc_unapplied_cash_payment_income'] = 'Unapplied Cash Payment Income';
$lang['acc_unapplied_cash_payment_income_note'] = 'Unapplied Cash Payment Income reports the Cash Basis income from customers payments you’ve received but not applied to invoices or charges. In general, you would never use this directly on a purchase or sale transaction.';
$lang['acc_dividend_income'] = 'Dividend income';
$lang['acc_dividend_income_note'] = 'Use Dividend income to track taxable dividends from investments.';
$lang['acc_interest_earned'] = 'Interest earned';
$lang['acc_interest_earned_note'] = 'Use Interest earned to track interest from bank or savings accounts, investments, or interest payments to you on loans your business made.';
$lang['acc_loss_on_disposal_of_assets'] = 'Loss on disposal of assets';
$lang['acc_loss_on_disposal_of_assets_note'] = 'Use Loss on disposal of assets to track losses realised on the disposal of assets.';
$lang['acc_other_investment_income'] = 'Other Investment Income';
$lang['acc_other_investment_income_note'] = 'Use Other investment income to track other types of investment income that isn’t from dividends or interest.';
$lang['acc_other_miscellaneous_income'] = 'Other Miscellaneous Income';
$lang['acc_other_miscellaneous_income_note'] = 'Use Other miscellaneous income to track income that isn’t from normal business operations, and doesn’t fall into another Other Income type.';
$lang['acc_other_operating_income'] = 'Other operating income';
$lang['acc_other_operating_income_note'] = 'Use Other operating income to track income from activities other than normal business operations. For example, Investment interest, foreign exchange gains, and rent income.';
$lang['acc_tax_exempt_interest'] = 'Tax-Exempt Interest';
$lang['acc_tax_exempt_interest_note'] = 'Use Tax-exempt interest to record interest that isn’t taxable, such as interest on money in tax-exempt retirement accounts, or interest from tax-exempt bonds.';
$lang['acc_unrealised_loss_on_securities_net_of_tax'] = 'Unrealised loss on securities, net of tax';
$lang['acc_unrealised_loss_on_securities_net_of_tax_note'] = 'Use Unrealised loss on securities, net of tax to track losses on securities that have occurred but are yet been realised through a transaction. For example, shares whose value has fallen but that are still being held.';
$lang['acc_cost_of_labour_cos'] = 'Cost of labour - COS';
$lang['acc_cost_of_labour_cos_note'] = 'Use Cost of labour - COS to track the cost of paying employees to produce products or supply services.
It includes all employment costs, including food and transportation, if applicable.';
$lang['acc_equipment_rental_cos'] = 'Equipment rental - COS';
$lang['acc_equipment_rental_cos_note'] = 'Use Equipment rental - COS to track the cost of renting equipment to produce products or services.
If you purchase equipment, use a Fixed Asset account type called Machinery and equipment.';
$lang['acc_freight_and_delivery_cos'] = 'Freight and delivery - COS';
$lang['acc_freight_and_delivery_cos_note'] = 'Use Freight and delivery - COS to track the cost of shipping/delivery of obtaining raw materials and producing finished goods for resale.';
$lang['acc_other_costs_of_sales_cos'] = 'Other costs of sales - COS';
$lang['acc_other_costs_of_sales_cos_note'] = 'Use Other costs of sales - COS to track costs related to services or sales that you provide that don’t fall into another Cost of Sales type.';
$lang['acc_supplies_and_materials_cos'] = 'Supplies and materials - COS';
$lang['acc_supplies_and_materials_cos_note'] = 'Use Supplies and materials - COS to track the cost of raw goods and parts used or consumed when producing a product or providing a service.';
$lang['acc_advertising_promotional'] = 'Advertising/Promotional';
$lang['acc_advertising_promotional_note'] = 'Use Advertising/promotional to track money spent promoting your company.
You may want different accounts of this type to track different promotional efforts (Yellow Pages, newspaper, radio, flyers, events, and so on).

If the promotion effort is a meal, use Promotional meals instead.';
$lang['acc_amortisation_expense'] = 'Amortisation expense';
$lang['acc_amortisation_expense_note'] = 'Use Amortisation expense to track writing off of assets (such as intangible assets or investments) over the projected life of the assets.';
$lang['acc_auto'] = 'Auto';
$lang['acc_auto_note'] = 'Use Auto to track costs associated with vehicles.
You may want different accounts of this type to track petrol, repairs, and maintenance.

If your business owns a car or lorry, you may want to track its value as a Fixed Asset, in addition to tracking its expenses.';
$lang['acc_bad_debts'] = 'Bad debts';
$lang['acc_bad_debts_note'] = 'Use Bad debt to track debt you have written off.';
$lang['acc_bank_charges'] = 'Bank charges';
$lang['acc_bank_charges_note'] = 'Use Bank charges for any fees you pay to financial institutions.';
$lang['acc_charitable_contributions'] = 'Charitable Contributions';
$lang['acc_charitable_contributions_note'] = 'Use Charitable contributions to track gifts to charity.';
$lang['acc_commissions_and_fees'] = 'Commissions and fees';
$lang['acc_commissions_and_fees_note'] = 'Use Commissions and fees to track amounts paid to agents (such as brokers) in order for them to execute a trade.';
$lang['acc_cost_of_labour'] = 'Cost of Labour';
$lang['acc_cost_of_labour_note'] = 'Use Cost of labour to track the cost of paying employees to produce products or supply services.
It includes all employment costs, including food and transportation, if applicable.

This account is also available as a Cost of Sales (COS) account.';
$lang['acc_dues_and_subscriptions'] = 'Dues and Subscriptions';
$lang['acc_dues_and_subscriptions_note'] = 'Use Dues and subscriptions to track dues and subscriptions related to running your business.
You may want different accounts of this type for professional dues, fees for licences that can’t be transferred, magazines, newspapers, industry publications, or service subscriptions.';
$lang['acc_equipment_rental'] = 'Equipment rental';
$lang['acc_equipment_rental_note'] = 'Use Equipment rental to track the cost of renting equipment to produce products or services.
This account is also available as a Cost of Sales account.

If you purchase equipment, use a Fixed asset account type called Machinery and equipment.';
$lang['acc_finance_costs'] = 'Finance costs';
$lang['acc_finance_costs_note'] = 'Use Finance costs to track the costs of obtaining loans or credit.
Examples of finance costs would be credit card fees, interest and mortgage costs.';
$lang['acc_income_tax_expense'] = 'Income tax expense';
$lang['acc_income_tax_expense_note'] = 'Use Income tax expense to track income taxes that the company has paid to meet their tax obligations.';
$lang['acc_insurance'] = 'Insurance';
$lang['acc_insurance_note'] = 'Use Insurance to track insurance payments.
You may want different accounts of this type for different types of insurance (auto, general liability, and so on).';
$lang['acc_interest_paid'] = 'Interest paid';
$lang['acc_interest_paid_note'] = 'Use Interest paid for all types of interest you pay, including mortgage interest, finance charges on credit cards, or interest on loans.';
$lang['acc_legal_and_professional_fees'] = 'Legal and professional fees';
$lang['acc_legal_and_professional_fees_note'] = 'Use Legal and professional fees to track money to pay to professionals to help you run your business.
You may want different accounts of this type for payments to your accountant, attorney, or other consultants.';
$lang['acc_loss_on_discontinued_operations_net_of_tax'] = 'Loss on discontinued operations, net of tax';
$lang['acc_loss_on_discontinued_operations_net_of_tax_note'] = 'Use Loss on discontinued operations, net of tax to track the loss realised when a part of the business ceases to operate or when a product line is discontinued.';
$lang['acc_management_compensation'] = 'Management compensation';
$lang['acc_management_compensation_note'] = 'Use Management compensation to track remuneration paid to Management, Executives and non-Executives. For example, salary, fees, and benefits.';
$lang['acc_meals_and_entertainment'] = 'Meals and entertainment';
$lang['acc_meals_and_entertainment_note'] = 'Use Meals and entertainment to track how much you spend on dining with your employees to promote morale.
If you dine with a customer to promote your business, use a Promotional meals account, instead.

Be sure to include who you ate with and the purpose of the meal when you enter the transaction.';
$lang['acc_office_general_administrative_expenses'] = 'Office/General Administrative Expenses';
$lang['acc_office_general_administrative_expenses_note'] = 'Use Office/general administrative expenses to track all types of general or office-related expenses.';
$lang['acc_other_miscellaneous_service_cost'] = 'Other Miscellaneous Service Cost';
$lang['acc_other_miscellaneous_service_cost_note'] = 'Use Other miscellaneous service cost to track costs related to providing services that don’t fall into another Expense type.
This account is also available as a Cost of Sales (COS) account.';
$lang['acc_other_selling_expenses'] = 'Other selling expenses';
$lang['acc_other_selling_expenses_note'] = 'Use Other selling expenses to track selling expenses incurred that do not fall under any other category.';
$lang['acc_payroll_expenses'] = 'Payroll Expenses';
$lang['acc_payroll_expenses_note'] = 'Use Payroll expenses to track payroll expenses. You may want different accounts of this type for things like:
- Compensation of officers
- Guaranteed payments
- Workers compensation
- Salaries and wages
- Payroll taxes';
$lang['acc_rent_or_lease_of_buildings'] = 'Rent or Lease of Buildings';
$lang['acc_rent_or_lease_of_buildings_note'] = 'Use Rent or lease of buildings to track rent payments you make.';
$lang['acc_repair_and_maintenance'] = 'Repair and maintenance';
$lang['acc_repair_and_maintenance_note'] = 'Use Repair and maintenance to track any repairs and periodic maintenance fees.
You may want different accounts of this type to track different types repair & maintenance expenses (auto, equipment, landscape, and so on).';
$lang['acc_shipping_and_delivery_expense'] = 'Shipping and delivery expense';
$lang['acc_shipping_and_delivery_expense_note'] = 'Use Shipping and delivery expense to track the cost of shipping and delivery of goods to customers.';
$lang['acc_supplies_and_materials'] = 'Supplies and materials';
$lang['acc_supplies_and_materials_note'] = 'Use Supplies & materials to track the cost of raw goods and parts used or consumed when producing a product or providing a service.
This account is also available as a Cost of Sales account.';
$lang['acc_taxes_paid'] = 'Taxes Paid';
$lang['acc_taxes_paid_note'] = 'Use Taxes paid to track taxes you pay.
You may want different accounts of this type for payments to different tax agencies.';
$lang['acc_travel_expenses_general_and_admin_expenses'] = 'Travel expenses - general and admin expenses';
$lang['acc_travel_expenses_general_and_admin_expenses_note'] = 'Use Travel expenses - general and admin expenses to track travelling costs incurred that are not directly related to the revenue-generating operation of the company. For example, flight tickets and hotel costs when performing job interviews.';
$lang['acc_travel_expenses_selling_expense'] = 'Travel expenses - selling expense';
$lang['acc_travel_expenses_selling_expense_note'] = 'Use Travel expenses - selling expense to track travelling costs incurred that are directly related to the revenue-generating operation of the company. For example, flight tickets and hotel costs when selling products and services.';
$lang['acc_unapplied_cash_bill_payment_expense'] = 'Unapplied Cash Bill Payment Expense';
$lang['acc_unapplied_cash_bill_payment_expense_note'] = 'Unapplied Cash Bill Payment Expense reports the Cash Basis expense from supplier payment cheques you’ve sent but not yet applied to supplier bills. In general, you would never use this directly on a purchase or sale transaction.';
$lang['acc_utilities'] = 'Utilities';
$lang['acc_utilities_note'] = 'Use Utilities to track utility payments.
You may want different accounts of this type to track different types of utility payments (gas and electric, telephone, water, and so on).';
$lang['acc_amortisation'] = 'Amortisation';
$lang['acc_amortisation_note'] = 'Use Amortisation to track amortisation of intangible assets.
Amortisation is spreading the cost of an intangible asset over its useful life, like depreciation of fixed assets.

You may want an amortisation account for each intangible asset you have.';
$lang['acc_depreciation'] = 'Depreciation';
$lang['acc_depreciation_note'] = 'Use Depreciation to track how much you depreciate fixed assets.
You may want a depreciation account for each fixed asset you have.';
$lang['acc_exchange_gain_or_loss'] = 'Exchange Gain or Loss';
$lang['acc_exchange_gain_or_loss_note'] = 'Use Exchange Gain or Loss to track gains or losses that occur as a result of exchange rate fluctuations.';
$lang['acc_other_expense'] = 'Other Expense';
$lang['acc_other_expense_note'] = 'Use Other expense to track unusual or infrequent expenses that don’t fall into another Other Expense type.';
$lang['acc_penalties_and_settlements'] = 'Penalties and settlements';
$lang['acc_penalties_and_settlements_note'] = 'Use Penalties and settlements to track money you pay for violating laws or regulations, settling lawsuits, or other penalties.';
$lang['acc_fixed_assets'] = 'Fixed assets';
$lang['acc_non_current_assets'] = 'Non-current assets';
$lang['acc_current_liabilities'] = 'Current liabilities';
$lang['acc_non_current_liabilities'] = 'Non-current liabilities';
$lang['acc_income'] = 'Income';
$lang['acc_other_income'] = 'Other income';
$lang['acc_cost_of_sales'] = 'Cost of sales';
$lang['acc_expenses'] = 'Expenses';
$lang['account_type'] = 'Account type';
$lang['detail_type'] = 'Detail type';
$lang['number'] = 'Number';
$lang['parent_account'] = 'Parent account';
$lang['as_of'] = 'as of';
$lang['acc_account'] = 'Account';
$lang['acc_available_for_sale_assets_short_term'] = 'Available for sale assets (short-term)';
$lang['acc_billable_expense_income'] = 'Billable Expense Income';
$lang['acc_change_in_inventory_cos'] = 'Change in inventory - COS';
$lang['acc_deferred_tax_assets'] = 'Deferred tax assets';
$lang['acc_direct_labour_cos'] = 'Direct labour - COS';
$lang['acc_discounts_given_cos'] = 'Discounts given - COS';
$lang['acc_shipping_freight_and_delivery_cos'] = 'Shipping, Freight and Delivery - COS';
$lang['acc_insurance_disability'] = 'Insurance - Disability';
$lang['acc_insurance_general'] = 'Insurance - General';
$lang['acc_insurance_liability'] = 'Insurance - Liability';
$lang['acc_intangibles'] = 'Intangibles';
$lang['acc_interest_income'] = 'Interest income';
$lang['acc_interest_expense'] = 'Interest expense';
$lang['acc_inventory_asset'] = 'Inventory Asset';
$lang['acc_materials_cos'] = 'Materials - COS';
$lang['acc_office_expenses'] = 'Office expenses';
$lang['acc_other_cos'] = 'Other - COS';
$lang['acc_other_general_and_administrative_expenses'] = 'Other general and administrative expenses';
$lang['acc_other_operating_income_expenses'] = 'Other operating income (expenses)';
$lang['acc_other_type_of_expenses_advertising_expenses'] = 'Other Types of Expenses-Advertising Expenses';
$lang['acc_overhead_cos'] = 'Overhead - COS';
$lang['acc_property_plant_and_equipment'] = 'Property, plant and equipment';
$lang['acc_purchases'] = 'Purchases';
$lang['acc_reconciliation_discrepancies'] = 'Reconciliation Discrepancies';
$lang['acc_rent_or_lease_payments'] = 'Rent or lease payments';
$lang['acc_sales'] = 'Sales';
$lang['acc_short_term_debit'] = 'Short-term debit';
$lang['acc_stationery_and_printing'] = 'Stationery and printing';
$lang['acc_subcontractors_cos'] = 'Subcontractors - COS';
$lang['acc_supplies'] = 'Supplies';
$lang['acc_uncategorised_asset'] = 'Uncategorised Asset';
$lang['acc_uncategorised_expense'] = 'Uncategorised Expense';
$lang['acc_uncategorised_income'] = 'Uncategorised Income';
$lang['acc_wage_expenses'] = 'Wage expenses';
$lang['add_failure'] = 'Add failure';
$lang['updated_fail'] = 'Updated fail';
$lang['primary_balance'] = 'Primary balance';
$lang['bank_balance'] = 'Bank balance';
$lang['converted'] = 'Has been mapped';
$lang['has_not_been_converted'] = 'Has not been mapped';
$lang['successfully_converted'] = 'Successfully mapping';
$lang['conversion_failed'] = 'Mapping failed';
$lang['transfer_funds_from'] = 'Transfer funds from';
$lang['transfer_funds_to'] = 'Transfer funds to';
$lang['transfer_amount'] = 'Transfer amount';
$lang['successfully_transferred'] = 'Successfully transferred';
$lang['transfer_failed'] = 'Transfer failed';
$lang['acc_convert'] = 'Mapping';
$lang['journal_date'] = 'Journal date';
$lang['please_balance_debits_and_credits'] = 'Please balance debits and credits.';
$lang['you_must_fill_out_at_least_two_detail_lines'] = 'You must fill out at least two detail lines.';
$lang['business_overview'] = 'Business overview';
$lang['audit_log'] = 'Audit Log';
$lang['balance_sheet_comparison'] = 'Balance Sheet Comparison';
$lang['balance_sheet_detail'] = 'Balance Sheet Detail';
$lang['balance_sheet_summary'] = 'Balance Sheet Summary';
$lang['balance_sheet'] = 'Balance Sheet';
$lang['business_snapshot'] = 'Business Snapshot';
$lang['custom_summary_report'] = 'Custom Summary Report';
$lang['profit_and_loss_as_of_total_income'] = 'Profit and Loss as &#37; of total income';
$lang['profit_and_loss_comparison'] = 'Profit and Loss Comparison';
$lang['profit_and_loss_detail'] = 'Profit and Loss Detail';
$lang['profit_and_loss_year_to_date_comparison'] = 'Profit and Loss year-to-date comparison';
$lang['profit_and_loss_by_customer'] = 'Profit and Loss by Customer';
$lang['profit_and_loss_by_month'] = 'Profit and Loss by Month';
$lang['profit_and_loss'] = 'Profit and Loss';
$lang['quarterly_profit_and_loss_summary'] = 'Quarterly Profit and Loss Summary';
$lang['statement_of_cash_flows'] = 'Statement of Cash Flows';
$lang['statement_of_changes_in_equity'] = 'Statement of Changes in Equity';
$lang['audit_log_note'] = 'Shows everything that has happened in your company file so you always know who\'s been in system and what they\'ve done.';
$lang['balance_sheet_comparison_note'] = 'What you own (assets), what you owe (liabilities), and what you invested (equity) compared to last year.';
$lang['balance_sheet_detail_note'] = 'A detailed view of what you own (assets), what you owe (liabilities), and what you invested (equity).';
$lang['balance_sheet_summary_note'] = 'A summary of what you own (assets), what you owe (liabilities), and what you invested (equity).';
$lang['balance_sheet_note'] = 'What you own (assets), what you owe (liabilities), and what you invested (equity).';
$lang['business_snapshot_note'] = 'Charts and graphs of your income and expenses and how they\'ve change over time.';
$lang['custom_summary_report_note'] = 'A report you build from scratch. With more options to customise.';
$lang['profit_and_loss_as_of_total_income_note'] = 'Your expenses as a percentage of your total income.';
$lang['profit_and_loss_comparison_note'] = 'Your income, expenses, and net income (profit or loss) compared to last year.';
$lang['profit_and_loss_detail_note'] = 'Profit and Loss Detail';
$lang['profit_and_loss_year_to_date_comparison_note'] = 'Your income, expenses, and net income (profit or loss) compared to this year so far.';
$lang['profit_and_loss_by_customer_note'] = 'Your income, expenses, and net income (profit or loss) by customer.';
$lang['profit_and_loss_by_month_note'] = 'Your income, expenses, and net income (profit or loss) by month.';
$lang['profit_and_loss_note'] = 'Your income, expenses, and net income (profit or loss). Also called an income statement.';
$lang['quarterly_profit_and_loss_summary_note'] = 'A summary of your income, expenses, and net income (profit or loss) by quarter.';
$lang['statement_of_cash_flows_note'] = 'Cash flowing in and out from sales and expenses (operating activities), investments, and financing.';
$lang['statement_of_changes_in_equity_note'] = 'Statement of changes in equity.';
$lang['sales_and_customers'] = 'Sales and customers';
$lang['customer_contact_list'] = 'Customer Contact List';
$lang['deposit_detail'] = 'Deposit Detail';
$lang['estimates_by_customer'] = 'Estimates by Customer';
$lang['income_by_customer_summary'] = 'Income by Customer Summary';
$lang['inventory_valuation_detail'] = 'Inventory Valuation Detail';
$lang['inventory_valuation_summary'] = 'Inventory Valuation Summary';
$lang['payment_method_list'] = 'Payment Method List';
$lang['product_service_list'] = 'Product/Service List';
$lang['sales_by_customer_detail'] = 'Sales by Customer Detail';
$lang['sales_by_customer_summary'] = 'Sales by Customer Summary';
$lang['sales_by_product_service_detail'] = 'Sales by Product/Service Detail';
$lang['sales_by_product_service_summary'] = 'Sales by Product/Service Summary';
$lang['stock_take_worksheet'] = 'Stock Take Worksheet';
$lang['time_activities_by_customer_detail'] = 'Time Activities by Customer Detail';
$lang['transaction_list_by_customer'] = 'Transaction List by Customer';
$lang['customer_contact_list_note'] = 'Phone number, email, billing address, and other contact info for each customer.';
$lang['deposit_detail_note'] = 'Your deposits, with the date, customer or supplier, and amount.';
$lang['estimates_by_customer_note'] = 'Your estimates, grouped by customer. Shows whether they\'re accepted and invoiced.';
$lang['income_by_customer_summary_note'] = 'Your income minus your expenses (net income) for each customer.';
$lang['inventory_valuation_detail_note'] = 'The quantity on hand, value, and average cost for each inventory item.';
$lang['inventory_valuation_summary_note'] = 'Your transactions for each inventory item, and how they affect quantity on hand, value, and cost.';
$lang['payment_method_list_note'] = 'The payment methods (cash, cheque, card, and so on) you accept from customers.';
$lang['product_service_list_note'] = 'Your products and services, with the sales price, name, description, and (optionally) purchase cost and quantity on hand.';
$lang['sales_by_customer_detail_note'] = 'Your sales, grouped by customer. Includes the date, type, amount, and total.';
$lang['sales_by_customer_summary_note'] = 'Your total sales for each customer.';
$lang['sales_by_product_service_detail_note'] = 'Your sales, grouped by product or service. Includes the date, transaction type, quantity, rate, amount, and total.';
$lang['sales_by_product_service_summary_note'] = 'Your total sales for each product or service. Includes the quantity, amount, % of sales, and average price.';
$lang['stock_take_worksheet_note'] = 'Your inventory items, with space to enter your physical count so you can compare to the quantity on hand in system.';
$lang['time_activities_by_customer_detail_note'] = 'The products and services (time activities) your employees provided to each customer.';
$lang['transaction_list_by_customer_note'] = 'Your transactions (income and expenses), grouped by customer.';
$lang['expenses_and_suppliers'] = 'Expenses and suppliers';
$lang['check_detail'] = 'Check Detail';
$lang['expenses_by_supplier_summary'] = 'Expenses by Supplier Summary';
$lang['purchases_by_product_service_detail'] = 'Purchases by Product/Service Detail';
$lang['purchases_by_supplier_detail'] = 'Purchases by Supplier Detail';
$lang['supplier_contact_list'] = 'Supplier Contact List';
$lang['transaction_list_by_supplier'] = 'Transaction List by Supplier';
$lang['check_detail_note'] = 'The checks you\'ve written, with the date, payee, and amount.';
$lang['expenses_by_supplier_summary_note'] = 'Your total expenses for each supplier.';
$lang['purchases_by_product_service_detail_note'] = 'Your purchases, grouped by product or service.';
$lang['purchases_by_supplier_detail_note'] = 'Your purchases, grouped by supplier.';
$lang['supplier_contact_list_note'] = 'Name, company, phone number, email, mailing address, and account number for each supplier.';
$lang['transaction_list_by_supplier_note'] = 'Your transactions, grouped by supplier.';
$lang['employee_contact_list'] = 'Employee Contact List';
$lang['recent_edited_time_activities'] = 'Recent/Edited Time Activities';
$lang['time_activities_by_employee_detail'] = 'Time Activities by Employee Detail';
$lang['employee_contact_list_note'] = 'Phone number, email, and other contact info for each employee.';
$lang['recent_edited_time_activities_note'] = 'The time activities your employees recently entered or edited.';
$lang['time_activities_by_employee_detail_note'] = 'The products and services (time activities) each employee provided, including hourly rate and duration.';
$lang['employee_contact_list'] = 'Employee Contact List';
$lang['recent_edited_time_activities'] = 'Recent/Edited Time Activities';
$lang['time_activities_by_employee_detail'] = 'Time Activities by Employee Detail';
$lang['employee_contact_list_note'] = 'Phone number, email, and other contact info for each employee.';
$lang['recent_edited_time_activities_note'] = 'The time activities your employees recently entered or edited.';
$lang['time_activities_by_employee_detail_note'] = 'The products and services (time activities) each employee provided, including hourly rate and duration.';
$lang['acc_assets'] = 'Assets';
$lang['long_term_assets'] = 'Long-term assets';
$lang['liabilities_and_shareholders_equity'] = 'Liabilities and shareholder\'s equity';
$lang['accounts_payable'] = 'Accounts Payable';
$lang['total_assets'] = 'Total Assets';
$lang['total_long_term_assets'] = 'Total long-term assets';
$lang['total_current_assets'] = 'Total Current Assets';
$lang['total_accounts_receivable'] = 'Total Accounts receivable';
$lang['total_accounts_payable'] = 'Total Accounts payable';
$lang['total_current_liabilities'] = 'Total current liabilities';
$lang['total_non_current_liabilities'] = 'Total non-current liabilities';
$lang['total_shareholders_equity'] = 'Total shareholders\' equity';
$lang['shareholders_equity'] = 'Shareholders\' equity';
$lang['total_liabilities_and_equity'] = 'Total liabilities and equity';
$lang['transaction_type'] = 'Transaction type';
$lang['total_for'] = 'Total for %s';
$lang['total_cost_of_sales'] = 'Total Cost of Sales';
$lang['total_other_income_loss'] = 'Total Other Income(Loss)';
$lang['total_expenses'] = 'Total expenses';
$lang['acc_other_expenses'] = 'Other Expenses';
$lang['total_other_expenses'] = 'Total Other Expense';
$lang['gross_profit_uppercase'] = 'GROSS PROFIT';
$lang['net_earnings_uppercase'] = 'NET EARNINGS';
$lang['percent_of_income'] = '&#37; of Income';
$lang['acc_ordinary_income_expenses'] = 'Ordinary Income/Expenses';
$lang['gross_profit'] = 'Gross Profit';
$lang['acc_net_income'] = 'Net Income';
$lang['cash_flows_from_operating_activities'] = 'Cash flows from operating activities';
$lang['profit_for_the_year'] = 'Profit for the year';
$lang['adjustments_for_non_cash_income_and_expenses'] = 'Adjustments for non-cash income and expenses';
$lang['total_adjustments_for_non_cash_income_and_expenses'] = 'Total Adjustments for non-cash income and expenses';
$lang['net_cash_from_operating_activities'] = 'Net cash from operating activities';
$lang['cash_flows_from_investing_activities'] = 'Cash flows from investing activities';
$lang['net_cash_used_in_investing_activities'] = 'Net cash used in investing activities';
$lang['cash_flows_from_financing_activities'] = 'Cash flows from financing activities';
$lang['net_increase_decrease_in_cash_and_cash_equivalents_uppercase'] = 'NET INCREASE (DECREASE) IN CASH AND CASH EQUIVALENTS';
$lang['cash_and_cash_equivalents_at_end_of_year_uppercase'] = 'CASH AND CASH EQUIVALENTS AT END OF YEAR';
$lang['cash_and_cash_equivalents_at_beginning_of_year'] = 'Cash and cash equivalents at beginning of year';
$lang['net_cash_used_in_financing_activities'] = 'Net cash used in financing activities';
$lang['total_cash_and_cash_equivalents_at_beginning_of_year'] = 'Total Cash and cash equivalents at beginning of year';
$lang['total_equity'] = 'Total Equity';
$lang['cheque_detail'] = 'Cheque Detail';
$lang['employees'] = 'Employees';
$lang['for_my_accountant'] = 'For my accountant';
$lang['account_list'] = 'Account list';
$lang['account_list_note'] = 'The name, type, and balance for each account in your chart of accounts.';
$lang['exceptions_to_closing_date'] = 'Exceptions to Closing Date';
$lang['exceptions_to_closing_date_note'] = 'Transactions dated before the closing date that you changed after closing the books.';
$lang['general_ledger'] = 'General Ledger';
$lang['general_ledger_note'] = 'The beginning balance, transactions, and total for each account in your chart of accounts.';
$lang['journal'] = 'Journal';
$lang['journal_note'] = 'The debits and credits for each transaction, listed by date.';
$lang['recent_transactions'] = 'Recent Transactions';
$lang['recent_transactions_note'] = 'Transactions you created or edited in the last 4 days.';
$lang['reconciliation_reports'] = 'Reconciliation Reports';
$lang['reconciliation_reports_note'] = 'A list of your reconciliations, with links to individual reconcilation reports.';
$lang['recurring_template_list'] = 'Recurring Template List';
$lang['recurring_template_list_note'] = 'A list of your recurring transaction templates, grouped by type (scheduled, reminder, and unscheduled).';
$lang['transaction_detail_by_account'] = 'Transaction Detail by Account';
$lang['transaction_detail_by_account_note'] = 'Transactions and total for each account in your chart of accounts.';
$lang['transaction_list_by_date'] = 'Transaction List by Date';
$lang['transaction_list_by_date_note'] = 'A list of all your transactions, ordered by date.';
$lang['transaction_list_with_splits'] = 'Transaction List with Splits';
$lang['transaction_list_with_splits_note'] = 'All your transactions, with splits.';
$lang['trial_balance'] = 'Trial Balance';
$lang['trial_balance_note'] = 'This report summarises the debit and credit balances of each account on your chart of accounts during a period of time.';
$lang['payroll'] = 'Payroll';
$lang['acc_expense'] = 'Expense';
$lang['export_to_pdf'] = 'Export to PDF';
$lang['export_to_excel'] = 'Export to Excel';
$lang['file_xlsx_banking'] = 'The column with the symbol "*" is required to enter.';
$lang['withdrawals'] = 'Withdrawals';
$lang['deposits'] = 'Deposits';
$lang['payee'] = 'Payee';
$lang['this_quarter'] = 'This Quarter';
$lang['last_quarter'] = 'Last Quarter';
$lang['banking_rules'] = 'Banking rules';
$lang['deposit_to'] = 'Deposit to';
$lang['reconcile_an_account'] = 'Reconcile an account';
$lang['open_your_statement_and_we_will_get_started'] = 'Open your statement and we\'ll get started.';
$lang['which_account_do_you_want_to_reconcile'] = 'Which account do you want to reconcile?';
$lang['add_the_following_information'] = 'Add the following information';
$lang['enter_the_service_charge_or_interest_earned_if_necessary'] = 'Enter the service charge or interest earned, if necessary';
$lang['beginning_balance'] = 'Beginning balance';
$lang['ending_balance'] = 'Ending balance';
$lang['ending_date'] = 'Ending date';
$lang['service_charge'] = 'Service charge';
$lang['expense_account'] = 'Expense account';
$lang['interest_earned'] = 'Interest earned';
$lang['income_account'] = 'Income account';
$lang['start_reconciling'] = 'Start reconciling';
$lang['resume_reconciling'] = 'Resume reconciling';
$lang['statement_ending_balance_uppercase'] = 'STATEMENT ENDING BALANCE';
$lang['cleared_balance_uppercase'] = 'CLEARED BALANCE';
$lang['beginning_balance_uppercase'] = 'BEGINNING BALANCE';
$lang['payments_uppercase'] = 'PAYMENTS';
$lang['deposits_uppercase'] = 'DEPOSITS';
$lang['difference_uppercase'] = 'DIFFERENCE';
$lang['deposit'] = 'Deposit';
$lang['edit_info'] = 'Edit info';
$lang['save_for_later'] = 'Save for later';
$lang['finish_now'] = 'Finish now';
$lang['finish_difference_header'] = 'Hold on! Your difference isn\'t 0.00 yet.';
$lang['finish_difference_note'] = 'If you\'d still like to proceed, confirm the following below, and then click Add adjustment and finish.';
$lang['add_adjustment_and_finish'] = 'Add adjustment and finish';
$lang['adjustment_date'] = 'Adjustment date';
$lang['cheque_expense'] = 'Cheque Expense';
$lang['reconcile_adjustment'] = 'Reconcile Adjustment';
$lang['edit_the_information_from_your_statement'] = 'Edit the information from your statement';
$lang['edit_the_following_if_necessary'] = 'Edit the following, if necessary';
$lang['payment_account'] = 'Payment account';
$lang['bank_accounts_uppercase'] = 'BANK ACCOUNTS';
$lang['everything_else'] = 'Everything else';
$lang['open_invoice'] = 'Open invoice';
$lang['overdue_invoices'] = 'Overdue invoices';
$lang['paid_last_30_days'] = 'Paid last 30 days';
$lang['accounting_dashboard'] = 'Accounting - Dashboard';
$lang['accounting_transaction'] = 'Accounting - Transaction';
$lang['accounting_journal_entry'] = 'Accounting - Journal entry';
$lang['accounting_transfer'] = 'Accounting - Transfer';
$lang['accounting_chart_of_accounts'] = 'Accounting - Chart of accounts';
$lang['accounting_reconcile'] = 'Accounting - Reconcile';
$lang['accounting_report'] = 'Accounting - Report';
$lang['accounting_setting'] = 'Accounting - Setting';
$lang['contains'] = 'Contains';
$lang['does_not_contain'] = 'Doesn\'t Contain';
$lang['is_exactly'] = 'Is exactly';
$lang['apply_this_to_transactions_that_are'] = 'Apply this to transactions that are';
$lang['and_include_the_following'] = 'and include the following';
$lang['any'] = 'Any';
$lang['money_out'] = 'Money out';
$lang['money_in'] = 'Money in';
$lang['assign'] = 'Assign';
$lang['exclude'] = 'Exclude';
$lang['then'] = 'Then';
$lang['automatically_confirm_transactions_this_rule_applies_to'] = 'Automatically confirm transactions this rule applies to';
$lang['auto_add'] = 'Auto-add';
$lang['does_not_equal'] = 'Does not equal';
$lang['equals'] = 'Equals';
$lang['is_greater_than'] = 'Is greater than';
$lang['is_less_than'] = 'Is less than';
$lang['banking_rule'] = 'Banking rule';
$lang['finish_difference_note_1'] = 'You aren\'t ready to reconcile yet because your transactions in system don\'t match your statement. When they match, you\'ll have a difference of 0.00.';
$lang['all_dates'] = 'All dates';
$lang['back_to_report_list'] = 'Back to report list';
$lang['last_30_days'] = 'Last 30 days';
$lang['split'] = 'Split';
$lang['account_history'] = 'Account history';
$lang['decrease'] = 'Decrease';
$lang['increase'] = 'Increase';
$lang['account_history_note'] = 'Account history';
$lang['equity'] = 'Equity';

$lang['dashboard'] = 'Dashboard';
$lang['accounting_report'] = 'Reports';
$lang['setting'] = 'Setting';
$lang['description'] = 'Description';
$lang['status'] = 'Status';
$lang['import_excel'] = 'Import excel';
$lang['download_sample'] = 'Download sample';
$lang['file_xlsx_format'] = 'Format excel file (type : text) before entering value.';
$lang['choose_excel_file'] = 'Choose excel file';
$lang['amount'] = 'Amount';
$lang['bookkeeping'] = 'Bookkeeping';
$lang['cash'] = 'Cash';
$lang['debit'] = 'Debit';
$lang['credit'] = 'Credit';
$lang['type'] = 'Type';
$lang['balance'] = 'Balance';
$lang['general'] = 'General';
$lang['total'] = 'Total';
$lang['customer'] = 'Customer';
$lang['reset_data'] = 'Reset data';
$lang['accounting_reset_button_tooltip'] = 'It will delete all data related to the accounting module';
$lang['total_income'] = 'Total income';
$lang['has_closed_the_book'] = 'Has closed the book';
$lang['cash_method_note_1'] = '- When you use the cash method in reports:';
$lang['cash_method_note_2'] = '+ Your report counts income or expenses as though they happened when you got the payment or paid the bill';
$lang['cash_method_note_3'] = '+ If you sent an invoice or got a bill but the money hasn’t changed hands yet, your report doesn’t include it in your income or expenses';
$lang['automatic_conversion'] = 'Automatic mapping';
$lang['automatic_conversion_note'] = 'Transactions excluding banking will be automatically converted';
$lang['charge'] = 'Charge';
$lang['_Result']                                     						= 'Result';
$lang['import_line_number']                                     			= 'Line number entered';
$lang['import_line_number_success']                                     	= 'Number of lines successfully entered';
$lang['import_line_number_failed']                                     		= 'Line number entered was unsuccessful';
$lang['hr_download_file_error']                                     		= 'Download error file';
$lang['cannot_delete_transaction_already_exists'] = 'Cannot delete an account when a transaction already exists';
$lang['expense_default'] = 'Expense default';
$lang['invoice_default_for_all_item'] = 'Invoice: Default for all item';
$lang['item_automatic'] = 'Item automatic mapping';
$lang['inventory_asset_account'] = 'Inventory asset account';
$lang['acc_item'] = 'Item';
$lang['mass_convert'] = 'Mass mapping';
$lang['mass_delete_convert'] = 'Mass delete mapping';
$lang['total_converted'] = 'Total mapped: %s';
$lang['total_convert_deleted'] = 'Total mapping deleted: %s';
$lang['total_deleted'] = 'Total deleted: %s';
$lang['transaction_not_yet_converted'] = 'The transaction has not been mapped';
$lang['list_of_items'] = 'List of items';
$lang['reset_data_successfully'] = 'Reset data successfully';
$lang['mapping_setup'] = 'Mapping setup';
$lang['item_mapping_setup'] = 'Item mapping setup';
$lang['has_been_mapping'] = 'Has been mapped';
$lang['cash_flow'] = 'Cash flow';
$lang['sales_have_been_mapping'] = 'Sales have been mapped';
$lang['expenses_have_been_mapping'] = 'Expenses have been mapped';
$lang['expense_account_overview'] = 'Expense account overview';
$lang['tax_default'] = 'Tax default';
$lang['tax_mapping_setup'] = 'Tax mapping setup';
$lang['tax_mapping'] = 'Tax mapping';
$lang['download_file_error'] = 'Download error file';
$lang['currency_converter'] = 'Currency converter';
$lang['exchange_rate'] = 'Exchange Rate';
$lang['acc_amount'] = 'Amount';
$lang['sales_tax'] = 'Sales tax';
$lang['tax_detail_report'] = 'Tax Detail Report';
$lang['tax_detail_report_note'] = 'This report lists the transactions that are included in each box on the tax return. The report is based on accrual accounting unless you changed your tax reporting preference to cash basis.';
$lang['tax_exception_report'] = 'Tax Exception Report';
$lang['tax_exception_report_note'] = 'This report lists the transactions containing tax that have been added, modified or deleted in prior filed tax periods and have changed the companys tax liability.';
$lang['tax_summary_report'] = 'Tax Summary Report';
$lang['tax_summary_report_note'] = 'This report shows you the summary information for each box of the tax return. The report is based on accrual accounting unless you changed your tax reporting preference to cash basis.';
$lang['tax_liability_report'] = 'Tax Liability Report';
$lang['tax_liability_report_note'] = 'How much sales tax you\'ve collected and how much you owe to tax agencies.';
$lang['mass_activate'] = 'Mass Activate';
$lang['mass_deactivate'] = 'Mass Deactivate';
$lang['total_activate'] = 'Total activate: %s';
$lang['total_deactivate'] = 'Total deactivate: %s';
$lang['expense_category_mapping'] = 'Expense category mapping';
$lang['tax_collected_on_sales'] = 'Tax collected on sales';
$lang['total_taxable_sales_in_period_before_tax'] = 'Total taxable sales in period, before tax';
$lang['tax_name'] = 'Tax name';
$lang['tax_rate'] = 'Tax rate';
$lang['taxable_amount'] = 'Taxable amount';
$lang['subtotal_of_tax_on_sales_uppercase'] = 'SUBTOTAL OF TAX ON SALES';
$lang['adjustments_to_tax_on_sales'] = 'Adjustments to tax on sales';
$lang['total_purchases_in_period_before_tax'] = 'Total purchases in period, before tax';
$lang['total_taxable_purchases_in_period_before_tax'] = 'Total taxable purchases in period, before tax';
$lang['tax_reclaimable_on_purchases'] = 'Tax reclaimable on purchases';
$lang['adjustments_to_reclaimable_tax_on_purchases'] = 'Adjustments to reclaimable tax on purchases';
$lang['subtotal_of_tax_on_purchases_uppercase'] = 'SUBTOTAL OF TAX ON PURCHASES';
$lang['balance_owing_for_period_uppercase'] = 'BALANCE OWING FOR PERIOD';
$lang['other_adjustments'] = 'Other adjustments';
$lang['current_balance_owing_for_period_uppercase'] = 'CURRENT BALANCE OWING FOR PERIOD';
$lang['tax_due_or_credit_from_previous_periods'] = 'Tax due (or credit) from previous periods';
$lang['tax_payments_made_this_period'] = 'Tax payments made this period';
$lang['total_amount_due_uppercase'] = 'TOTAL AMOUNT DUE';
$lang['financial_year'] = 'Financial year';
$lang['amount_after_convert'] = 'Amount after convert';
$lang['acc_converted'] = 'Has been mapped';
$lang['payment_mode_mapping'] = 'Payment mode mapping';

$lang['accrual_method_note_1'] = '- When you use the accrual method in reports:';
$lang['accrual_method_note_2'] = '+ Your report counts income and expenses as if they happened when you sent the invoice or got the bill';
$lang['accrual_method_note_3'] = '+ It includes income and expenses even if the money hasn’t changed hands yet';
$lang['account_type_details'] = 'Account detail types';
$lang['account_type_detail'] = 'Account detail type';
$lang['cannot_delete_account_already_exists'] = 'Cannot delete an account detail type when a account already exists';
$lang['acc_export_excel'] = 'Export to excel';
$lang['other_shareholder_equity'] = 'Other shareholder\'s equity';
$lang['acc_preferred_payment_method'] = 'Preferred the payment method';
$lang['mapping_status'] = 'Mapping status';
$lang['acc_invoice_status'] = 'Invoice status';