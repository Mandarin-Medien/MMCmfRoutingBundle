# MMCmfRoutingBundle

### Append to app/AppKernel.php
You need to add the bundle to your app/AppKernel.php. This bundle also requires the MMCmfNodeBundle, so make sure this bundle is also registered.

```
...
    public function registerBundles()
    {
        $bundles = array(
            ...
            new MandarinMedien\MMCmfPageBundle\MMCmfNodeBundle(),
            new MandarinMedien\MMCmfPageBundle\MMCmfRoutingBundle(),
            ...
            );
    ....
    }
...
```

