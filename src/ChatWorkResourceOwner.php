<?php

namespace ChatWork\OAuth2\Client;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

/**
 * @package ChatWork\OAuth2\Client
 */
final class ChatWorkResourceOwner implements ResourceOwnerInterface
{
    /**
     * @var int
     */
    private $accountId;

    /**
     * @var int
     */
    private $roomId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $chatworkId;

    /**
     * @var int
     */
    private $organizationId;

    /**
     * @var string
     */
    private $organizationName;

    /**
     * @var string
     */
    private $department;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $introduction;

    /**
     * @var string
     */
    private $mail;

    /**
     * @var string
     */
    private $telOrganization;

    /**
     * @var string
     */
    private $telExtension;

    /**
     * @var
     */
    private $telMobile;

    /**
     * @var string
     */
    private $skype;

    /**
     * @var string
     */
    private $facebook;

    /**
     * @var string
     */
    private $twitter;

    /**
     * @var string
     */
    private $avatarImageUrl;

    /**
     * @var string
     */
    private $loginMail;

    /**
     * @param int $accountId
     * @param int $roomId
     * @param string $name
     * @param string $chatworkId
     * @param int $organizationId
     * @param string $organizationName
     * @param string $department
     * @param string $title
     * @param string $url
     * @param string $introduction
     * @param string $mail
     * @param string $telOrganization
     * @param string $telExtension
     * @param string $telMobile
     * @param string $skype
     * @param string $facebook
     * @param string $twitter
     * @param string $avatarImageUrl
     * @param string $loginMail
     */
    public function __construct(int $accountId,
                                int $roomId,
                                string $name,
                                string $chatworkId,
                                int $organizationId,
                                string $organizationName,
                                string $department,
                                string $title,
                                string $url,
                                string $introduction,
                                string $mail,
                                string $telOrganization,
                                string $telExtension,
                                string $telMobile,
                                string $skype,
                                string $facebook,
                                string $twitter,
                                string $avatarImageUrl,
                                string $loginMail)
    {
        $this->accountId = $accountId;
        $this->roomId = $roomId;
        $this->name = $name;
        $this->chatworkId = $chatworkId;
        $this->organizationId = $organizationId;
        $this->organizationName = $organizationName;
        $this->department = $department;
        $this->title = $title;
        $this->url = $url;
        $this->introduction = $introduction;
        $this->mail = $mail;
        $this->telOrganization = $telOrganization;
        $this->telExtension = $telExtension;
        $this->telMobile = $telMobile;
        $this->skype = $skype;
        $this->facebook = $facebook;
        $this->twitter = $twitter;
        $this->avatarImageUrl = $avatarImageUrl;
        $this->loginMail = $loginMail;
    }


    /**
     * Returns the identifier of the authorized resource owner.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->accountId;
    }

    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            "account_id"        => $this->accountId,
            "room_id"           => $this->roomId,
            "name"              => $this->name,
            "chatwork_id"       => $this->chatworkId,
            "organization_id"   => $this->organizationId,
            "organization_name" => $this->organizationName,
            "department"        => $this->department,
            "title"             => $this->title,
            "url"               => $this->url,
            "introduction"      => $this->introduction,
            "mail"              => $this->mail,
            "tel_organization"  => $this->telOrganization,
            "tel_extension"     => $this->telExtension,
            "tel_mobile"        => $this->telMobile,
            "skype"             => $this->skype,
            "facebook"          => $this->facebook,
            "twitter"           => $this->twitter,
            "avatar_image_url"  => $this->avatarImageUrl,
            "login_mail"        => $this->loginMail
        ];
    }

    /**
     * @return int
     */
    public function getAccountId(): int
    {
        return $this->accountId;
    }

    /**
     * @return int
     */
    public function getRoomId(): int
    {
        return $this->roomId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getChatworkId(): string
    {
        return $this->chatworkId;
    }

    /**
     * @return int
     */
    public function getOrganizationId(): int
    {
        return $this->organizationId;
    }

    /**
     * @return string
     */
    public function getOrganizationName(): string
    {
        return $this->organizationName;
    }

    /**
     * @return string
     */
    public function getDepartment(): string
    {
        return $this->department;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getIntroduction(): string
    {
        return $this->introduction;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @return string
     */
    public function getTelOrganization(): string
    {
        return $this->telOrganization;
    }

    /**
     * @return string
     */
    public function getTelExtension(): string
    {
        return $this->telExtension;
    }

    /**
     * @return mixed
     */
    public function getTelMobile()
    {
        return $this->telMobile;
    }

    /**
     * @return string
     */
    public function getSkype(): string
    {
        return $this->skype;
    }

    /**
     * @return string
     */
    public function getFacebook(): string
    {
        return $this->facebook;
    }

    /**
     * @return string
     */
    public function getTwitter(): string
    {
        return $this->twitter;
    }

    /**
     * @return string
     */
    public function getAvatarImageUrl(): string
    {
        return $this->avatarImageUrl;
    }

    /**
     * @return string
     */
    public function getLoginMail(): string
    {
        return $this->loginMail;
    }

}
