<?php

/*
 * This file is part of the awurth/silex-user package.
 *
 * (c) Alexis Wurth <awurth.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AWurth\Silex\User\Document;

use AWurth\Silex\User\Model\User as BaseUser;
use AWurth\Silex\User\Validator\Constraints\Unique;
use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Base User document class.
 *
 * @author Alexis Wurth <awurth.dev@gmail.com>
 *
 * @ODM\MappedSuperclass
 */
abstract class User extends BaseUser
{
    /**
     * @var int
     *
     * @ODM\Id
     */
    protected $id;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $username;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $email;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $password;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $salt;

    /**
     * @var bool
     *
     * @ODM\Field(type="boolean")
     */
    protected $enabled = false;

    /**
     * @var DateTime
     *
     * @ODM\Field(type="date")
     */
    protected $lastLogin;

    /**
     * @var array
     *
     * @ODM\Field(type="collection")
     */
    protected $roles = [];

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $confirmationToken;

    /**
     * {@inheritdoc}
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint(new Unique([
            'fields' => 'username',
            'message' => 'silex_user.username.already_used'
        ]));
        $metadata->addConstraint(new Unique([
            'fields' => 'email',
            'message' => 'silex_user.email.already_used'
        ]));

        parent::loadValidatorMetadata($metadata);
    }
}
