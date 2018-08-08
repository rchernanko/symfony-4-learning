<?php

namespace App\Controller;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\CacheItem;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CacheController
{
    /**
     * @Route("/cache", name="app_cache", methods={"GET"})
     *
     * @param AdapterInterface $cache
     *
     * @return Response
     *
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function cacheDemoAction(AdapterInterface $cache): Response
    {
        //Let's put something in the cache.

        /** @var CacheItem $item */
        $item = $cache->getItem('name');

        //First, let's check if the key 'name' exists in the cache already.
        //If it doesn't, we will add it so that the next time, we can retrieve it from the cache
        if (!$item->isHit()) {
            $item->set('richard chernanko');
            $cache->save($item);
        }

        return new Response($item->get());
    }
}
