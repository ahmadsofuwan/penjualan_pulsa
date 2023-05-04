@extends('layout.master')
@section('content')
    <div class="bg-gray-800 pt-3 flex">
        <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
            <h1 class="font-bold pl-2">Transaction</h1>
        </div>
        <button id="add" title="add">
            <svg viewBox="0 0 448 512" class="w-5 h-fit text-yellow-500 font-black">
                <path class="fill-current stroke-current stroke-2"
                    d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
            </svg>

        </button>

    </div>

    <div class="w-full mt-5 mx-3 h-full">

        <table id="table" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
            <thead>
                <tr>
                    <th>Customers</th>
                    <th>Paid State</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>
                        {{ $transaction->name }}
                    </td>
                    <td>
                        {{ $transaction->debitcredit }}
                    </td>
                    <td class="text-right">
                        {{ number_format($transaction->amount) }}
                    </td>
                    <td>
                        {{ date('d-m-Y H:i', strtotime($transaction->created_at)) }}
                    </td>
                    <td>
                        {{ $transaction->description }}
                    </td>
                    <td class="grid lg:grid-cols-2 grid-cols-1 gap-4 justify-items-center">
                        <button title="delete" class="delete w-5 h-fit text-red-500 font-black"
                            data-delete="{{ route('customers.delete', ['id' => encrypt($customer->id)]) }}">
                            <svg viewBox="0 0 448 512">
                                <path class="fill-current stroke-current stroke-2"
                                    d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                            </svg>
                        </button>
                        <button title="Edit" class="edit w-5 h-fit text-green-500 font-black"
                            data-id="{{ encrypt($customer->id) }}" data-value={{ $customer->name }}>
                            <svg viewBox="0 0 512 512">
                                <path class="fill-current stroke-current stroke-2"
                                    d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                            </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
            <tbody>

            </tbody>

        </table>





    </div>

    <script>
        $(document).ready(function() {
            var table = $('#table').DataTable({
                    responsive: true
                })
                .columns.adjust()
                .responsive.recalc();

            $('#add').click(function() {
                Swal.fire({
                    title: 'Add Transaction',
                    html: `
                    <form method="post" action="{{ route('transaction.add') }}" class="grid grid-cols-1 gap-4">
                        @csrf

                        <select name="customer_id" data-te-select-init class=" peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0">
                            <option selected disabled>Pilih Customers</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"> {{ $customer->name }} </option>
                            @endforeach
                        </select>

                        <select name="produc" data-te-select-init class=" peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0">
                            <option selected disabled>Pilih Producs</option>
                            <option valeu="pulsa">Pulsa</option>
                            <option valeu="listrik">Listrik</option>
                        </select>


                        <input type="number" class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            placeholder="Amount" name="amount" />
                        <select name="debitcredit" data-te-select-init class=" peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0">
                            <option selected disabled>Metode Pembayaran</option>
                            <option value="debit">Debit</option>
                            <option value="credit">Credit</option>
                         </select>
                            <textarea
                                class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                rows="3"
                                name="secription"
                                placeholder="Description"></textarea>

                        <button
                            type="submit"
                            class="mt-3 inline-block rounded bg-blue-500 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-blue-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-blue-500 600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-blue-500 700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                            data-te-ripple-init
                            data-te-ripple-color="light">
                            Submit
                        </button>

                    </form>

                    `,
                    showCloseButton: true,
                    showConfirmButton: false,
                })
            })
            $('.edit').click(function() {
                var id = $(this).attr('data-id');
                var val = $(this).attr('data-value');
                Swal.fire({
                    title: 'Add Customer',
                    html: `
                    <form method="post" action="{{ route('customers.edit') }}">
                        @csrf
                        <input type="hidden" name="id" value="${id}">
                        <div class="relative mb-3" data-te-input-wrapper-init>
                        <input type="text" class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            placeholder="Name" name="name" value="${val}" />
                        <button
                            type="submit"
                            class="mt-3 inline-block rounded bg-blue-500 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-blue-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-blue-500 600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-blue-500 700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                            data-te-ripple-init
                            data-te-ripple-color="light">
                            Submit
                        </button>

                    </form>

                    `,
                    showCloseButton: true,
                    showConfirmButton: false,
                })
            })
            $('.delete').click(function() {
                var link = $(this).attr('data-delete');
                Swal.fire({
                    title: 'Delete',
                    text: "Data akan di hapus",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = link;
                    }
                })
            });


        });
    </script>
@endsection
