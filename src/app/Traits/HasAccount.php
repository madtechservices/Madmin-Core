<?php

namespace Madtechservices\MadminCore\app\Traits;

use Madtechservices\MadminCore\app\Scopes\AccountScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Madtechservices\MadminCore\app\Models\Account;

trait HasAccount
{
    protected static function booted()
    {
        static::addGlobalScope(new AccountScope());
    }

    public function scopeWithoutAccountScope($query)
    {
        return $query->withoutGlobalScope(AccountScope::class);
    }
    
    public function account(): BelongsTo
    {
        return $this->belongsTo(config('madmin-core.config.account_model_fqn', Account::class));
    }
}
