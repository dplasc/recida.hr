<style>
    .boxShadow-06 {
        box-shadow: 0rem 0.625rem 1.875rem rgba(0, 0, 0, 0.06);
    }
    .dl_column_item {
        border-radius: 0.3125rem;
    }
    .fz-15-r-gray {
        font-size: 0.9375rem;
        font-weight: 400;
        line-height: 1.5rem;
        color: #69696a;
    }
    .fz-20-sb-black {
        font-size: 1.25rem;
        font-weight: 600;
        line-height: 1.875rem;
        color: #0b162d;
    }
    .fz-24-b-black {
        font-size: 1.5rem;
        font-weight: 600;
        line-height: 1.8125rem;
        color: #0b162d;
    }
    .bg-white {
        background-color: #fff;
    }
    .pb-30 {
        padding-bottom: 1.875rem;
    }
    .pt-22 {
        padding-top: 1.375rem;
    }
    .px-30 {
        padding-right: 1.875rem;
        padding-left: 1.875rem;
    }
    .bd-b-1 {
        border-bottom: 0.0625rem solid #d4d4d4;
    }
    .pb-22 {
        padding-bottom: 1.375rem;
    }
    .mb-30 {
        margin-bottom: 1.875rem;
    }
    .rg-30 {
        row-gap: 1.875rem;
    }
    .pb-10 {
        padding-bottom: 0.625rem;
    }
    .modify-bill {
        min-width: 7.4375rem !important;
        height: 2.8125rem !important;
        display: flex;
        justify-content: center;
        align-items: center;
        padding-left: 1.25rem !important;
        padding-right: 1.25rem !important;
        background-color: #fff !important;
        text-decoration: none;
        vertical-align: middle;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        border: 0.0625rem solid #929292 !important;
        border-radius: 0.3125rem;
        font-size: 0.9375rem;
        font-weight: 500 !important;
        line-height: 1.1875rem;
        color: #929292 !important;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .modify-bill:hover {
        background-color: #929292 !important;
        color: #fff !important;
    }
    .fz-15-m-black {
        font-size: 0.9375rem;
        font-weight: 500;
        line-height: 0.9375rem;
        color: #0b162d;
    }
    .fz-15-sb-black {
        font-size: 0.9375rem;
        font-weight: 600;
        line-height: 0.9375rem;
        color: #0b162d;
    }
    .eTable {
        font-size: 0.9375rem !important;
        font-weight: 600 !important;
        color: #0b162d !important;
        margin-bottom: 0;
    }
    .eTable thead tr th {
        font-size: 0.9375rem;
        font-weight: 600;
        color: #0b162d;
        border-bottom: 0.06875rem solid #d4d4d4 !important;
    }
    .eTable-2 > :not(caption) > * > *:first-child {
        padding-left: 0px !important;
    }
    .table-pb0 tbody tr:last-child td {
        padding-bottom: 0 !important;
        border: 0;
    }
    .eTable-2 > :not(caption) > * > * {
        border-bottom: 1px dashed #d4d4d4;
        padding: 20px 16px !important;
        vertical-align: middle;
    }
    
    .subscription_active_status{
        color: #007BFF;
    }
    .subscription_deactive_status{
       color: #EF181B;
    }
    .bd-r-5 {
        border-radius: 0.3125rem;
    }
    .subscription-expired {
        background-color: #fcf4f6;
        border: 0.0625rem solid #ffb2c7;
    }
    .fz-18-sb-black {
        font-size: 1.125rem;
        font-weight: 600;
        line-height: 1.875rem;
        color: #0b162d;
    }
    .eBtn {
        display: inline-block;
        font-size: 0.875rem;
        font-weight: 500;
        line-height: 1.375rem;
        color: #fff;
        width: 7.4375rem;
        height: 2.5rem;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #007bff;
        text-align: center;
        text-decoration: none;
        vertical-align: middle;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        outline: none;
        border: 0.0625rem solid transparent;
        border-radius: 0.3125rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .expired-btn {
        width: 11.6875rem;
        height: 2.8125rem;
        border-radius: 0.3125rem;
        border: 0rem solid #007bff;
        background-color: #007bff !important;
        font-size: 0.9375rem;
        font-weight: 500;
        line-height: 1.1875rem;
        color: #fff;
    }
    .py-30 {
        padding-top: 1.875rem;
        padding-bottom: 1.875rem;
    }
    .px-30 {
        padding-right: 1.875rem;
        padding-left: 1.875rem;
    }
.pb-8 {
    padding-bottom: 0.5rem;
}
.fz-17-sb-black {
    font-size: 1.0625rem;
    font-weight: 600;
    line-height: 1.25rem;
    color: #0b162d;
}
.fz-15-r-gray {
    font-size: 0.9375rem;
    font-weight: 400;
    line-height: 1.5rem;
    color: #69696a;
}
.rg-22 {
    row-gap: 1.375rem;
}
.eForm-control2 {
    display: block;
    width: 100%;
    padding: 0.5625rem 1rem;
    font-size: 0.9375rem;
    font-weight: 400;
    line-height: 1.375rem;
    color: #69696a;
    background-color: #fff;
    background-clip: padding-box;
    border: 0.0625rem solid #cacfd4;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.3125rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.col-eForm-label {
    font-size: 1rem;
    font-weight: 500;
    line-height: 1.25rem;
    color: #0b162d;
}
.col-eForm-label {
    font-size: 15px;
}
.tDownloadIcon {
	width: 2.125rem;
	height: 2.125rem;
	border-radius: 0.3125rem;
	display: flex;
	justify-content: center;
	align-items: center;
	color: #242D47 !important;
	margin: auto;
	cursor: pointer;
	background: #F7F8FA;
    transform: .5s
}
.tDownloadIcon:hover{
    background: #E7E9ED;
}

</style>