<?php

namespace App\Traits;

use App\Constants\Status;

trait UserNotify
{
    public static function notifyToUser()
    {
        return [
            'allUsers'               => 'All Users',
            'selectedUsers'          => 'Selected Users',
            'kycUnverified'          => 'Kyc Unverified Users',
            'kycVerified'            => 'Kyc Verified Users',
            'kycPending'             => 'Kyc Pending Users',
            'withBalance'            => 'With Balance Users',
            'emptyBalanceUsers'      => 'Empty Balance Users',
            'twoFaDisableUsers'      => '2FA Disable User',
            'twoFaEnableUsers'       => '2FA Enable User',
            'hasDepositedUsers'      => 'Deposited Users',
            'notDepositedUsers'      => 'Not Deposited Users',
            'pendingDepositedUsers'  => 'Pending Deposited Users',
            'rejectedDepositedUsers' => 'Rejected Deposited Users',
            'topDepositedUsers'      => 'Top Deposited Users',
            'hasWithdrawUsers'       => 'Withdraw Users',
            'pendingWithdrawUsers'   => 'Pending Withdraw Users',
            'rejectedWithdrawUsers'  => 'Rejected Withdraw Users',
            'pendingTicketUser'      => 'Pending Ticket Users',
            'answerTicketUser'       => 'Answer Ticket Users',
            'closedTicketUser'       => 'Closed Ticket Users',
            'notLoginUsers'          => 'Last Few Days Not Login Users',
            'onlineUSers'            => 'Self-registered users',
            'branchUsers'            => 'Users who have registered via Branch',
            'allFdrUsers'            => 'All FDR Users',
            'runningFdrUsers'        => 'Running FDR Users',
            'closedFdrUsers'         => 'Closed FDR Users',
            'dueFdrUsers'            => 'Due FDR Users',
            'allDpsUsers'            => 'All DPS Users',
            'runningDpsUsers'        => 'Running DPS Users',
            'dueDpsUsers'            => 'Due DPS Users',
            'maturedDpsUsers'        => 'Matured DPS Users',
            'closedDpsUsers'         => 'Closed DPS Users',
            'pendingLoanUsers'       => 'Pending Loan Users',
            'runningLoanUsers'       => 'Running Loan Users',
            'dueLoanUsers'           => 'Due Loan Users',
            'paidLoanUsers'          => 'Paid Loan Users',
            'rejectedLoanUsers'      => 'Rejected Loan Users',
            'allLoanUsers'           => 'All Loan Users',
            'pendingTransferUsers'   => 'Pending Transfer Users',
            'rejectedTransferUsers'  => 'Rejected Transfer Users',
        ];
    }

    public function scopeSelectedUsers($query)
    {
        return $query->whereIn('id', request()->user ?? []);
    }

    public function scopeAllUsers($query)
    {
        return $query;
    }

    public function scopeEmptyBalanceUsers($query)
    {
        return $query->where('balance', '<=', 0);
    }

    public function scopeTwoFaDisableUsers($query)
    {
        return $query->where('ts', Status::DISABLE);
    }

    public function scopeTwoFaEnableUsers($query)
    {
        return $query->where('ts', Status::ENABLE);
    }

    public function scopeHasDepositedUsers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->successful();
        });
    }

    public function scopeNotDepositedUsers($query)
    {
        return $query->whereDoesntHave('deposits', function ($q) {
            $q->successful();
        });
    }

    public function scopePendingDepositedUsers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->pending();
        });
    }

    public function scopeRejectedDepositedUsers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->rejected();
        });
    }

    public function scopeTopDepositedUsers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->successful();
        })->withSum(['deposits' => function ($q) {
            $q->successful();
        }], 'amount')->orderBy('deposits_sum_amount', 'desc')->take(request()->number_of_top_deposited_user ?? 10);
    }

    public function scopeHasWithdrawUsers($query)
    {
        return $query->whereHas('withdrawals', function ($q) {
            $q->approved();
        });
    }

    public function scopePendingWithdrawUsers($query)
    {
        return $query->whereHas('withdrawals', function ($q) {
            $q->pending();
        });
    }

    public function scopeRejectedWithdrawUsers($query)
    {
        return $query->whereHas('withdrawals', function ($q) {
            $q->rejected();
        });
    }

    public function scopePendingTicketUser($query)
    {
        return $query->whereHas('tickets', function ($q) {
            $q->whereIn('status', [Status::TICKET_OPEN, Status::TICKET_REPLY]);
        });
    }

    public function scopeClosedTicketUser($query)
    {
        return $query->whereHas('tickets', function ($q) {
            $q->where('status', Status::TICKET_CLOSE);
        });
    }

    public function scopeAnswerTicketUser($query)
    {
        return $query->whereHas('tickets', function ($q) {
            $q->where('status', Status::TICKET_ANSWER);
        });
    }

    public function scopeKycVerified($query)
    {
        return $query->where('kv', Status::KYC_VERIFIED);
    }

    public function scopeNotLoginUsers($query)
    {
        return $query->whereDoesntHave('loginLogs', function ($q) {
            $q->whereDate('created_at', '>=', now()->subDays(request()->number_of_days ?? 10));
        });
    }

    public function scopeOnlineUSers($query)
    {
        return $query->where('branch_id', 0);
    }
    public function scopeBranchUsers($query)
    {
        return $query->whereIn('branch_id', request()->branch ?? [2]);
    }

    public function scopeAllFdrUsers($query)
    {
        return $query->whereHas('fdr');
    }
    public function scopeRunningFdrUsers($query)
    {
        return $query->whereHas('fdr', function ($q) {
            $q->running();
        });
    }
    public function scopeClosedFdrUsers($query)
    {
        return $query->whereHas('fdr', function ($q) {
            $q->closed();
        });
    }
    public function scopeDueFdrUsers($query)
    {
        return $query->whereHas('fdr', function ($q) {
            $q->due();
        });
    }
    public function scopeAllDpsUsers($query)
    {
        return $query->whereHas('dps');
    }
    public function scopeRunningDpsUsers($query)
    {
        return $query->whereHas('dps', function ($q) {
            $q->running();
        });
    }
    public function scopeDueDpsUsers($query)
    {
        return $query->whereHas('dps', function ($q) {
            $q->due();
        });
    }
    public function scopeMaturedDpsUsers($query)
    {
        return $query->whereHas('dps', function ($q) {
            $q->matured();
        });
    }
    public function scopeClosedDpsUsers($query)
    {
        return $query->whereHas('dps', function ($q) {
            $q->closed();
        });
    }

    public function scopePendingLoanUsers($query)
    {
        return $query->whereHas('loan', function ($q) {
            $q->pending();
        });
    }

    public function scopeRunningLoanUsers($query)
    {
        return $query->whereHas('loan', function ($q) {
            $q->running();
        });
    }
    public function scopeDueLoanUsers($query)
    {
        return $query->whereHas('loan', function ($q) {
            $q->due();
        });
    }
    public function scopePaidLoanUsers($query)
    {
        return $query->whereHas('loan', function ($q) {
            $q->paid();
        });
    }
    public function scopeRejectedLoanUsers($query)
    {
        return $query->whereHas('loan', function ($q) {
            $q->rejected();
        });
    }
    public function scopeAllLoanUsers($query)
    {
        return $query->whereHas('loan');
    }

    public function scopePendingTransferUsers($query)
    {
        return $query->whereHas('transfer', function ($q) {
            $q->pending();
        });
    }
    public function scopeRejectedTransferUsers($query)
    {
        return $query->whereHas('transfer', function ($q) {
            $q->rejected();
        });
    }
}
