<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\ConversationRepository;
use Illuminate\Database\Eloquent\Collection;

class ConversationController extends Controller
{
    private User $user;

    public function __construct(private readonly ConversationRepository $repository)
    {
        $this->user = User::find(1);
    }

    public function max(): Collection
    {
        return$this->repository->getUsingMax($this->user);
    }

    public function join(): Collection
    {
        return$this->repository->getUsingJoinAndMax($this->user);
    }

    public function eloquent(): Collection
    {
        return $this->repository->getUsingEloquentSubQuery($this->user);
    }

    public function allMax(): Collection
    {
        return$this->repository->getUsingMax();
    }

    public function allJoin(): Collection
    {
        return$this->repository->getUsingJoinAndMax();
    }

    public function allEloquent(): Collection
    {
        return $this->repository->getUsingEloquentSubQuery();
    }
}
