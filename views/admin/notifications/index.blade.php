@extends('oxygencms::admin.layout')

@section('title', 'Notifications')

@section('content')

    <div class="row">
        <div class="col-12 d-flex align-items-center mb-3">
            <h1>Notifications</h1>
        </div>
    </div>

    <vue-good-table
        :columns="[
            {label: 'Event', field: 'class'},
            {label: 'Description', field: 'description'},
            {label: 'Channels', field: 'channels'},
            {label: 'Active', field: 'active'},
            {label: 'Actions', field: 'actions', width: '100px', globalSearchDisabled: false, sortable: false},
        ]"
        :rows="models"
        :search-options="{enabled: true}"
        :pagination-options="{enabled: true}"
    >
        <template slot="table-row" slot-scope="props">
            <span v-if="props.column.label === 'Actions'" class="action-links">
                <a :href="props.row.edit_url" title="Edit">edit</a>
            </span>
            <span v-if="props.column.label === 'Active'">
                @{{ props.row.active ? '&#10003;' : '&#215;' }}
            </span>

            <span v-else v-text="props.formattedRow[props.column.field]"></span>
        </template>
    </vue-good-table>

    {{--<table-component :data="fetchTableData">--}}
        {{--<table-column :show="tableColumnShow('group')" label="Group"></table-column>--}}
        {{--<table-column show="key" label="Key"></table-column>--}}
        {{--<table-column :show="tableColumnShow('text')" label="Text"></table-column>--}}
        {{--<table-column label="Actions" :filterable="false" :sortable="false">--}}
            {{--<template slot-scope="row">--}}
                {{--<a :href="row.edit_url">Edit</a>--}}
                {{--<a href="" @click.prevent="confirmAndDelete(row)">Delete</a>--}}
            {{--</template>--}}
        {{--</table-column>--}}
    {{--</table-component>--}}

@endsection
