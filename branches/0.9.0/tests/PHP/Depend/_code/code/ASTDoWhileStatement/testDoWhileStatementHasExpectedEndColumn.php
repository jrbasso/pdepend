<?php
function testDoWhileStatementHasExpectedEndColumn()
{
    do {
        call_user_func(__FUNCTION__);
    }
    while ($i > 42 || $i < 23);
}