<?php

declare(strict_types=1);

namespace App\UI\Base;

use App\AppAdmin\CurrentAppAdminGetter;
use App\UI\Base\Menu\MenuBuilder;
use App\UI\Base\Modal\ModalRendererControl;
use App\UI\Base\Modal\ModalRendererControlFactory;
use LogicException;
use Nette\Application\UI\InvalidLinkException;
use Nette\Application\UI\Presenter;
use Nette\Utils\IHtmlString;

abstract class BasePresenter extends Presenter
{
	/** @var string */
	public const DEFAULT_MODAL_COMPONENT_NAME = 'modalRendererControl';

	protected ModalRendererControlFactory $modalRendererControlFactory;

	protected CurrentAppAdminGetter $currentAppAdminGetter;

	private ?string $modalComponentName = null;

	public function injectCurrentAppAdminGetter(CurrentAppAdminGetter $currentAppAdminGetter): void
	{
		$this->currentAppAdminGetter = $currentAppAdminGetter;
	}

	public function injectModalRendererControlFactory(ModalRendererControlFactory $modalRendererControlFactory): void
	{
		$this->modalRendererControlFactory = $modalRendererControlFactory;
	}

	public function startup(): void
	{
		parent::startup();
		if ($this->currentAppAdminGetter->isLoggedIn() === false) {
			$this->redirect('Login:default', ['backlink' => $this->storeRequest()]);
		}

		$this->template->appAdmin = $this->currentAppAdminGetter->getAppAdmin();
		$this->template->menuItems = (new MenuBuilder())->buildMenu();
	}

	public function showModal(
		string $componentName = self::DEFAULT_MODAL_COMPONENT_NAME,
		?string $heading = null,
		?IHtmlString $content = null
	): void {
		$modalComponent = $this->getComponent($componentName);
		if (! $modalComponent instanceof ModalRendererControl) {
			throw new LogicException(sprintf(
				'Component %s is not instance of %s',
				$componentName,
				ModalRendererControl::class
			));
		}

		$modalComponent->setParameters($heading, $content);
		$this->modalComponentName = $componentName;

		$this->payload->showModal = true;
		$this->payload->modalId = $modalComponent->getModalId();
		$this->redrawControl('modalComponentSnippet');
	}

	public function getModalComponentName(): ?string
	{
		return $this->modalComponentName;
	}

	/**
	 * @return string[]
	 */
	public function formatLayoutTemplateFiles(): array
	{
		return array_merge([__DIR__ . '/templates/@layout.latte'], parent::formatLayoutTemplateFiles());
	}

	/**
	 * @param string[] $links
	 * @throws InvalidLinkException
	 */
	public function isMenuLinkActive(array $links): bool
	{
		foreach ($links as $link) {
			if ($this->isLinkCurrent($link)) {
				return true;
			}
		}

		return false;
	}

	public function handleLogout(): void
	{
		$this->currentAppAdminGetter->logout();
		$this->redirect('this');
	}

	protected function createComponentModalRendererControl(): ModalRendererControl
	{
		return $this->modalRendererControlFactory->create();
	}
}
