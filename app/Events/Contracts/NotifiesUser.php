<?php

namespace App\Events\Contracts;

interface NotifiesUser
{
    public function getNotificationUserId(): int;

    public function getNotificationTemplateCode(): string;

    public function getNotificationVariables(): array;

    public function getNotificationPayload(): array;

    public function getNotificationMosqueId(): ?int;

    public function getNotificationChannel(): string;

    public function getNotificationLocale(): ?string;
}
