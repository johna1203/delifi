<?php
/**
 * ECGKodokux
 *
 *
 * @package    ${GROUP}
 * @subpackage ${MODULENAME}
 * @license    BSD License
 */


namespace FBLogin\Authentication\Adapter;

use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;
use Zend\Db\Sql\Predicate\Operator as SqlOp;
use Zend\Authentication\Result as AuthenticationResult;

class FacebookAdapter extends CredentialTreatmentAdapter
{


    protected function authenticateCreateSelect()
    {
        // get select
        $dbSelect = clone $this->getDbSelect();
        $dbSelect->from($this->tableName)
//            ->columns(array('*', $credentialExpression))
            ->where(new SqlOp($this->identityColumn, '=', $this->identity));

        return $dbSelect;
    }

    /**
     *
     * @param  array $resultIdentity
     * @return AuthenticationResult
     */
    protected function authenticateValidateResult($resultIdentity)
    {
        if (empty($resultIdentity)) {
            $this->authenticateResultInfo['code']       = AuthenticationResult::FAILURE_CREDENTIAL_INVALID;
            $this->authenticateResultInfo['messages'][] = 'Supplied credential is invalid.';

            return $this->authenticateCreateAuthResult();
        }

        $this->resultRow = $resultIdentity;

        $this->authenticateResultInfo['code']       = AuthenticationResult::SUCCESS;
        $this->authenticateResultInfo['messages'][] = 'Authentication successful.';

        return $this->authenticateCreateAuthResult();
    }
}