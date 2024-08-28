<?php

namespace App\Enums;

enum ApproveStatus :string{
    case Pending ="pending";
    case Cancelled ="cancelled";
    case Rejected ="rejected";
    case Freeze ="freeze";
    case Approved ="Approved";

}
