<?php

// Copyright 1999-2016. Parallels IP Holdings GmbH.
class Modules_DomainInfo_DomainInfo
{
    public static function getDomainInfo(pm_Domain $domain)
    {
        return [
            'id' => $domain->getId(),
            'guid' => $domain->getGuid(),
            'name' => $domain->getName(),
            'displayName' => $domain->getDisplayName(),
            'documentRoot' => $domain->getDocumentRoot(),
            'homePath' => $domain->getHomePath(),
            'vhostPath' => $domain->getVhostSystemPath(),
            'systemUser' => $domain->getSysUserLogin(),
            'clientLogin' => $domain->getClient()->getProperty('login'),
            'hasHosting' => pm_Locale::lmsg($domain->hasHosting() ? 'yes' : 'no'),
            'ipAddresses' => $domain->getIpAddresses(),
            'limits' => [
                'max_site' => static::getCoreLimit($domain, 'max_site'),
            ],
            'permissions' => [
                'manage_dns' => static::getCorePermission($domain, 'manage_dns'),
            ]
        ];
    }

    protected static function getCoreLimit(pm_Domain $domain, $limitName)
    {
        $limit = $domain->getCoreLimit($limitName);

        return -1 == $limit ? pm_Locale::lmsg('unlimited') : $limit;
    }


    protected static function getCorePermission(pm_Domain $domain, $permissionName)
    {
        $permission = $domain->hasCorePermission($permissionName);
        if (is_null($permission)) {
            return pm_Locale::lmsg('undefined');
        }

        return pm_Locale::lmsg($permission ? 'yes' : 'no');
    }
}
