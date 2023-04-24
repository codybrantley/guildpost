@extends('main')
@section('page')
<div class="row">
    <div class="large-6 columns">
        <h3>Global Rank Permissions</h3>
        <div class="permissions">
            @foreach($ranks as $rank)
            <div class="row">
                <div class="large-8 columns">
                    <img src="{{ $rank->icon }}" /> {{ $rank->id }}
                </div>
                <div class="large-4 columns">
                    <select>
                        <option value='1' selected>Default</option>
                        <option value='2'>Page Author</option>
                        <option value='3'>Page Manager</option>
                        <option value='4'>Event Manager</option>
                        <option value='5'>Contributor</option>
                        <option value='6'>Editor</option>
                        <option value='7'>Admin</option>
                    </select>
                </div>
            </div>
            @endforeach
            <div class="row">
                <button class="button">Save Changes</button>
            </div>
        </div>
    </div>
    <div class="large-6 columns">
        <h3>User-specific Permissions</h3>
        <div class="permissions">
            <div class="row">
                <div class="large-8 columns">
                    <select>
                        <option value='' selected disabled>--Select User--</option>
                        @foreach($ranks as $rank)
                        <optgroup label="{{ $rank->id }}">
                            @foreach($users as $user)
                            @if($user->rank == $rank->id)
                            <option>{{ $user->name }}</option>
                            @endif
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="large-4 columns">
                    <select>
                        <option value='1' selected>Default</option>
                        <option value='2'>Page Author</option>
                        <option value='3'>Page Manager</option>
                        <option value='4'>Event Manager</option>
                        <option value='5'>Contributor</option>
                        <option value='6'>Editor</option>
                        <option value='7'>Admin</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <button class="button">Save Changes</button>
            </div>
        </div>
    </div>
</div>
<h3>Permission Levels</h3>
<div class="row rankHelp">
    <div class="large-3 columns">
        <h6>Default</h6>
        <p>Only view access</p>
    </div>
    <div class="large-3 columns">
        <h6>Page Author</h6>
        <p>Able to add and manage only their pages</p>
    </div>
    <div class="large-3 columns">
        <h6>Page Manager</h6>
        <p>Able to add and manage any page</p>
    </div>
    <div class="large-3 columns">
        <h6>Event Coordinator</h6>
        <p>Able to add and manage only their events</p>
    </div>
    <div class="large-3 columns">
        <h6>Event Manager</h6>
        <p>Able to add and manage any event</p>
    </div>
    <div class="large-3 columns">
        <h6>Contributor</h6>
        <p>Able to add and manage only their pages/events</p>
    </div>
    <div class="large-3 columns">
        <h6>Editor</h6>
        <p>Able to add and manage any content</p>
    </div>
    <div class="large-3 columns">
        <h6>Admin</h6>
        <p>Full control of content and settings</p>
    </div>
</div>
@endsection
