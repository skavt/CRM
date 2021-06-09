<?php

use yii\db\Migration;

/**
 * Class m210609_110458_build_auth_data
 */
class m210609_110458_build_auth_data extends Migration
{
    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // -------------------------------------------------

        // Create post permissions
        $sharePost = $auth->createPermission('sharePost');
        $sharePost->description = 'Share Post';
        $auth->add($sharePost);

        $leaveComment = $auth->createPermission('leaveComment');
        $leaveComment->description = 'Leave Comment';
        $auth->add($leaveComment);

        $like = $auth->createPermission('like');
        $like->description = 'Like/Unlike';
        $auth->add($like);

        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create Post';
        $auth->add($createPost);

        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update Post';
        $auth->add($updatePost);

        $deletePost = $auth->createPermission('deletePost');
        $deletePost->description = 'Delete Post';
        $auth->add($deletePost);

        // Create user role
        $user = $auth->createRole('user');
        $user->description = 'User';
        $auth->add($user);

        // Give user post permissions
        $auth->addChild($user, $sharePost);
        $auth->addChild($user, $leaveComment);
        $auth->addChild($user, $like);

        $auth->addChild($user, $createPost);
        $auth->addChild($user, $updatePost);
        $auth->addChild($user, $deletePost);

        // -------------------------------------------------

        // Create channel permissions
        $createChannel = $auth->createPermission('createChannel');
        $createChannel->description = 'Create Channel';
        $auth->add($createChannel);

        $updateChannel = $auth->createPermission('updateChannel');
        $updateChannel->description = 'Update Channel';
        $auth->add($updateChannel);

        $deleteChannel = $auth->createPermission('deleteChannel');
        $deleteChannel->description = 'Delete Channel';
        $auth->add($deleteChannel);

        $addUser = $auth->createPermission('addUser');
        $addUser->description = 'Add User';
        $auth->add($addUser);

        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'Update User';
        $auth->add($updateUser);

        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Delete User';
        $auth->add($deleteUser);

        // Create channelAdmin role
        $channelAdmin = $auth->createRole('channelAdmin');
        $channelAdmin->description = 'Channel Admin';
        $auth->add($channelAdmin);

        // Give channelAdmin channel permissions
        $auth->addChild($channelAdmin, $createChannel);
        $auth->addChild($channelAdmin, $updateChannel);
        $auth->addChild($channelAdmin, $deleteChannel);

        $auth->addChild($channelAdmin, $addUser);
        $auth->addChild($channelAdmin, $updateUser);
        $auth->addChild($channelAdmin, $deleteUser);

        //Give channelAdmin all user permissions
        $auth->addChild($channelAdmin, $user);

        // -------------------------------------------------

        // Create admin role
        $admin = $auth->createRole('admin');
        $admin->description = 'Admin';
        $auth->add($admin);

        //Give admin all permissions
        $auth->addChild($admin, $channelAdmin);

        // Assign admin role to admin
        $auth->assign($admin, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
}
