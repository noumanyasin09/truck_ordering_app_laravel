@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Email</h1>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Send Email</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sendemail') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Subject <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ hasError($errors, 'subject') }}"
                                        name="subject" value="{{ old('subject') }}">
                                    <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Select Email <span class="text-danger ">*</span></label>
                                    <select name="email" id=""
                                        class="form-control select2 {{ hasError($errors, 'email') }}">
                                        <option value="">Choose</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->email }}">{{ $user->email }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Message <span class="text-danger">*</span> </label>
                                    <textarea id="editor" name="message" class="form-control {{ hasError($errors, 'message') }}"></textarea>
                                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script></script>
@endpush
