<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 30.03.15
 * Time: 09:33
 */

namespace RA\SilexRestApi\Connector\Oxid;


use RA\SilexRestApi\Filter\Constraint\Equals;
use RA\SilexRestApi\Filter\Constraint\Like;
use RA\SilexRestApi\Filter\Constraint\LogicalAnd;
use RA\SilexRestApi\Filter\Constraint\LogicalOr;
use RA\SilexRestApi\Filter\Filter;
use Symfony\Component\HttpFoundation\Request;

class DefaultProductFilter extends Filter
{

    public function setRequest(Request $request) {
        parent::setRequest($request);

        $search = $request->get('q');
        if (empty($search)) {
            $search = '';
        }

        $isBuyable = (bool) $request->get('ba');
        $buyableConstraint = false;
        if ($isBuyable) {
            $buyableConstraint = new Equals('OXVARCOUNT', 0);
        }

        $searchWords = preg_split('/[\s,]+/', $search, -1, PREG_SPLIT_NO_EMPTY);
        if (!empty($searchWords)) {
            $constraint = new LogicalOr(
                new LogicalAnd($this->buildConstraintArray('OXTITLE', $searchWords)),
                new LogicalAnd($this->buildConstraintArray('OXSHORTDESC', $searchWords)),
                new LogicalAnd($this->buildConstraintArray('OXARTNUM', $searchWords))
            );
            if ($buyableConstraint) {
                $constraint = new LogicalAnd(
                    $constraint,
                    $buyableConstraint
                );
            }
            $this->setRootConstraint($constraint);
        }
    }

    private function buildConstraintArray($fieldName, array $searchWords) {
        $return = array();
        foreach ($searchWords as $searchWord) {
            $return[] = new Like($fieldName, '%' . $searchWord . '%');
        }

        return $return;
    }
}
