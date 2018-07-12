<?php

namespace App\Http\Controllers;

use App\GitUser;
use Illuminate\Http\Request;
use App\Admin\GitUsers\SeedData;
use App\Jobs\SeedGithubUsers;

use Alert;

class GitUserController extends Controller
{
    public function seed()
    {
        SeedGithubUsers::dispatch(new SeedData);

        Alert::message('Seeding is started.');

        return redirect('git_users');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \response(GitUser::paginate(\request()->get('per_page', 20)), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        GitUser::create($request->toArray());

        return \response('User with id " . $gitUser->id . "was created successfully.', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GitUser  $gitUser
     * @return \Illuminate\Http\Response
     */
    public function show(GitUser $gitUser)
    {
        return \response($gitUser->toArray(), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GitUser  $gitUser
     * @return \Illuminate\Http\Response
     */
    public function edit(GitUser $gitUser)
    {
        $gitUser->update(request()->toArray());

        return \response('User was updated successfully.', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GitUser  $gitUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GitUser $gitUser)
    {
        $gitUser->update($request->toArray());

        return \response("User with id " . $gitUser->id . " was updated successfully.", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GitUser  $gitUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(GitUser $gitUser)
    {
        return \response('Now allowed.', 403);
    }
}
