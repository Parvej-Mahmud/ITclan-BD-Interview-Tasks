@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-8">
                        <form action="{{ route('idea.store') }}" method="POST" class="mb-3">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}">

                                @if ($errors->has('name'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}">

                                @if ($errors->has('email'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="idea" class="form-label fw-bold">Idea</label>
                                <textarea class="form-control" name="idea" id="idea" rows="3"></textarea>
                                <div id="ideaHelp" class="form-text">Max charecter limit is 500</div>

                                @if ($errors->has('idea'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('idea') }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                        </form>

                        @if (!empty($ideas))
                        <h4>Ideas History</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Idea</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ideas as $idea)
                                <tr>
                                    <td>{{ $idea->idea }}</td>
                                    <td>{{ $idea->updated_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>

                    @if (count($tournaments) > 0)
                    <div class="col-md-4">
                        <h4>Tournament Status</h4>

                        @foreach ($tournaments as $key => $tournament)
                        <div class="card mb-2">
                            <div class="card-body">
                                <h6>Participated</h6>
                                <ul>
                                    @foreach ($tournamentIdeas[$key] as  $idea1)
                                        <li>{{ $idea1->email }}</li>
                                    @endforeach
                                </ul>
                                @if (!empty($tournament->first_phase))
                                <h6>Top 4</h6>
                                <ul>
                                    @foreach ($tournament->first_phase as $idea2)
                                        @php
                                            $filteredIdea = $tournamentIdeas[$key]->filter(function ($item) use ($idea2) {
                                                return $item->id == $idea2;
                                            })->values();
                                        @endphp

                                        <li>{{ $filteredIdea[0]->email }}</li>
                                    @endforeach
                                </ul>
                                @endif
                                @if (!empty($tournament->second_phase))
                                <h6>Top 2</h6>
                                <ul>
                                    @foreach ($tournament->second_phase as $idea2)
                                        @php
                                            $filteredIdea = $tournamentIdeas[$key]->filter(function ($item) use ($idea2) {
                                                return $item->id == $idea2;
                                            })->values();
                                        @endphp

                                        <li>{{ $filteredIdea[0]->email }}</li>
                                    @endforeach
                                </ul>
                                @endif
                                @if (!empty($tournament->winner))
                                <h6>Winner</h6>
                                <ul>
                                    @foreach ($tournament->winner as $idea2)
                                        @php
                                            $filteredIdea = $tournamentIdeas[$key]->filter(function ($item) use ($idea2) {
                                                return $item->id == $idea2;
                                            })->values();
                                        @endphp

                                        <li>{{ $filteredIdea[0]->email }}</li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


