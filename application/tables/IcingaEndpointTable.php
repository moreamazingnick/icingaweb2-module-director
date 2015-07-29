<?php

namespace Icinga\Module\Director\Tables;

use Icinga\Module\Director\Web\Table\QuickTable;

class IcingaEndpointTable extends QuickTable
{
    protected $searchColumns = array(
        'endpoint',
    );

    public function getColumns()
    {
        return array(
            'id'       => 'e.id',
            'endpoint' => 'e.object_name',
            'address'  => 'e.address',
            'zone'     => 'z.object_name',
        );
    }

    protected function getActionUrl($row)
    {
        return $this->url('director/endpoint', array('name' => $row->endpoint));
    }

    public function getTitles()
    {
        $view = $this->view();
        return array(
            'endpoint' => $view->translate('Endpoint'),
            'address'  => $view->translate('Address'),
            'zone'     => $view->translate('Zone'),
        );
    }

    public function getBaseQuery()
    {
        $db = $this->connection()->getConnection();
        $query = $db->select()->from(
            array('e' => 'icinga_endpoint'),
            array()
        )->joinLeft(
            array('z' => 'icinga_zone'),
            'e.zone_id = z.id',
            array()
        );

        return $query;
    }
}
