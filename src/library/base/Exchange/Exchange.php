<?php


namespace iikoExchangeBundle\Library\base\Exchange;


use iikoExchangeBundle\Contract\AdapterInterface;
use iikoExchangeBundle\Contract\DataDownloadDriverInterface;
use iikoExchangeBundle\Contract\DataDownloadRequestInterface;
use iikoExchangeBundle\Contract\DataUploadDriverInterface;
use iikoExchangeBundle\Contract\ExchangeInterface;
use iikoExchangeBundle\Contract\ProviderInterface;
use Psr\Http\Message\RequestInterface;

abstract class Exchange implements ExchangeInterface
{
	/**
	 * @var ProviderInterface
	 */
	protected $downloadProvider;
	/** @var ProviderInterface */
	protected $uploadProvider;
	/** @var DataDownloadRequestInterface[] */
	protected $requests = [];
	/** @var AdapterInterface */
	protected $adapter;

	public function setDownloadProvider(ProviderInterface $provider)
	{
		$this->downloadProvider = $provider;

		return $this;
	}

	public function setUploadProvider(ProviderInterface $provider)
	{
		$this->uploadProvider = $provider;

		return $this;
	}

	public function setAdapter(AdapterInterface $adapter)
	{
		$this->adapter = $adapter;

		return $this;
	}

	public function addDataRequest(DataDownloadRequestInterface $request)
	{
		$this->requests[$request->getCode()] = $request;

		return $this;
	}

	abstract public function getCode(): string;

	public function register()
	{
		// TODO: Implement register() method.
	}

	public function process()
	{
		$data = [];

		foreach ($this->requests as $request)
		{
			$data[$request->getCode()] = $this->downloadProvider->sendRequest($request->getRequest());
		}
		/** @var RequestInterface $data */
		$data = $this->adapter->adapt($data);
		if(!($data instanceof RequestInterface))
		{
			throw new \Exception('Adapter must return RequestInterface to direct send to upload endpoint');
		}
		return $this->uploadProvider->sendRequest($data);

	}
}