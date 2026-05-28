<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLogs extends Model
{
    protected $fillable = ['user_id', 'action', 'table_name', 'record_id', 'old_value', 'new_value'];

    // Log by user
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}

// How to identify which relationship to use
// Question 1: Can A have many B?
// Question 2: Can B have many A?

// Both NO  → probably wrong design
// Q1 YES, Q2 NO  → One to Many (A hasMany B, B belongsTo A)
// Q1 NO, Q2 YES  → One to Many (B hasMany A, A belongsTo B)
// Both YES → Many to Many (need a pivot table)

// Applied to Your POS
// Can one category have many products? YES
// Can one product have many categories? NO
// → One to Many (Category hasMany Product)

// Can one sale have many products? YES
// Can one product appear in many sales? YES
// → Many to Many (via sale_items pivot)

// Can one sale have many payments? YES
// Can one payment belong to many sales? NO
// → One to Many (Sale hasMany Payment)

// Can one user process many sales? YES
// Can one sale be processed by many users? NO
// → One to Many (User hasMany Sale)

// Full Relationship Map of Your POS

//                     ┌──────────┐
//                     │categories│
//                     └────┬─────┘
//                     1:N  │ hasMany
//                          ▼
// ┌──────────┐       ┌──────────┐       ┌──────────────┐
// │suppliers │──────▶│ products │◀──────│  categories  │
// └────┬─────┘ 1:N   └────┬─────┘  1:N  └──────────────┘
//      │                  │ M:N via
//      │ hasMany           │ sale_items & purchase_items
//      ▼                  ▼
// ┌──────────┐       ┌──────────┐       ┌──────────┐
// │purchases │──────▶│  sales   │──────▶│ payments │
// └────┬─────┘ 1:N   └────┬─────┘ 1:N   └──────────┘
//      │                  │
//      │ hasMany           │ hasMany
//      ▼                  ▼
// ┌──────────────┐   ┌──────────┐       ┌──────────┐
// │purchase_items│   │sale_items│       │customers │
// └──────────────┘   └──────────┘       └──────────┘
//                                            │
//                         ┌──────────┐       │ hasMany
//                         │  users   │───────┘
//                         └────┬─────┘
//                              │ hasMany
//                     ┌────────┴────────┐
//                     ▼                 ▼
//                ┌─────────┐    ┌──────────┐
//                │expenses │    │audit_logs│
//                └─────────┘    └──────────┘

// The Three Rules to Always Remember
// RULE 1 — Look for the _id column
// The table that holds the foreign key (_id column)
// is ALWAYS the belongsTo side

// cities has country_id       → cities belongsTo countries
// employees has department_id → employees belongsTo departments

// RULE 2 — Count the rows to identify the type
// Can A have more than one B? → write YES or NO
// Can B have more than one A? → write YES or NO

// Both NO  → One to One   (1:1)
// One YES  → One to Many  (1:N)
// Both YES → Many to Many (M:N)

// RULE 3 — Look for a pivot table
// If you see a middle table holding two foreign keys
// from two different tables = always Many to Many