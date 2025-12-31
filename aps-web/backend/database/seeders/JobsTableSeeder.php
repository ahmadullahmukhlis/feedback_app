<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JobsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('jobs')->delete();
        
        \DB::table('jobs')->insert(array (
            0 => 
            array (
                'id' => 4,
                'queue' => 'default',
                'payload' => '{"uuid":"f824177b-a058-411e-a279-fad3903923a8","displayName":"App\\\\Jobs\\\\FetcherSeedFilesJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\FetcherSeedFilesJob","command":"O:28:\\"App\\\\Jobs\\\\FetcherSeedFilesJob\\":0:{}"},"createdAt":1767075386,"delay":null}',
                'attempts' => 1,
                'reserved_at' => 1767088500,
                'available_at' => 1767075386,
                'created_at' => 1767075386,
            ),
            1 => 
            array (
                'id' => 5,
                'queue' => 'default',
                'payload' => '{"uuid":"a6e42e8a-e230-4775-9343-c31aac7cb3d4","displayName":"App\\\\Events\\\\UserUpdatedEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:27:\\"App\\\\Events\\\\UserUpdatedEvent\\":1:{s:6:\\"result\\";s:13:\\"Updated event\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"},"createdAt":1767075646,"delay":null}',
                'attempts' => 0,
                'reserved_at' => NULL,
                'available_at' => 1767075646,
                'created_at' => 1767075646,
            ),
            2 => 
            array (
                'id' => 6,
                'queue' => 'default',
                'payload' => '{"uuid":"8f31e602-2675-48f6-8a44-3cc72ecb7d71","displayName":"App\\\\Events\\\\UserUpdatedEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:27:\\"App\\\\Events\\\\UserUpdatedEvent\\":1:{s:6:\\"result\\";a:3:{s:9:\\"is_active\\";b:1;s:7:\\"message\\";s:0:\\"\\";s:7:\\"user_id\\";i:3;}}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"},"createdAt":1767075928,"delay":null}',
                'attempts' => 0,
                'reserved_at' => NULL,
                'available_at' => 1767075928,
                'created_at' => 1767075928,
            ),
            3 => 
            array (
                'id' => 7,
                'queue' => 'default',
                'payload' => '{"uuid":"f892d885-78b8-469f-a2a2-2c397ce55b1e","displayName":"App\\\\Events\\\\UserUpdatedEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:27:\\"App\\\\Events\\\\UserUpdatedEvent\\":1:{s:6:\\"result\\";s:13:\\"Updated event\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"},"createdAt":1767076018,"delay":null}',
                'attempts' => 0,
                'reserved_at' => NULL,
                'available_at' => 1767076018,
                'created_at' => 1767076018,
            ),
            4 => 
            array (
                'id' => 8,
                'queue' => 'default',
                'payload' => '{"uuid":"f559a872-9cb9-4a67-9aef-5044cd89dd02","displayName":"App\\\\Events\\\\UserUpdatedEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:27:\\"App\\\\Events\\\\UserUpdatedEvent\\":1:{s:6:\\"result\\";a:3:{s:9:\\"is_active\\";b:1;s:7:\\"message\\";s:0:\\"\\";s:7:\\"user_id\\";i:3;}}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"},"createdAt":1767076041,"delay":null}',
                'attempts' => 0,
                'reserved_at' => NULL,
                'available_at' => 1767076041,
                'created_at' => 1767076041,
            ),
            5 => 
            array (
                'id' => 9,
                'queue' => 'default',
                'payload' => '{"uuid":"a9036252-13ca-42a7-b4ed-8ad6b080de6c","displayName":"App\\\\Events\\\\UserUpdatedEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:27:\\"App\\\\Events\\\\UserUpdatedEvent\\":1:{s:6:\\"result\\";s:13:\\"Updated event\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"},"createdAt":1767076151,"delay":null}',
                'attempts' => 0,
                'reserved_at' => NULL,
                'available_at' => 1767076151,
                'created_at' => 1767076151,
            ),
            6 => 
            array (
                'id' => 10,
                'queue' => 'default',
                'payload' => '{"uuid":"6297c701-661f-4899-981d-33fe10dedc02","displayName":"App\\\\Events\\\\UserUpdatedEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:27:\\"App\\\\Events\\\\UserUpdatedEvent\\":1:{s:6:\\"result\\";s:13:\\"Updated event\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"},"createdAt":1767076262,"delay":null}',
                'attempts' => 0,
                'reserved_at' => NULL,
                'available_at' => 1767076262,
                'created_at' => 1767076262,
            ),
            7 => 
            array (
                'id' => 11,
                'queue' => 'default',
                'payload' => '{"uuid":"1433dcab-b97e-4652-b6f4-41f5af222e89","displayName":"App\\\\Events\\\\UserUpdatedEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:27:\\"App\\\\Events\\\\UserUpdatedEvent\\":1:{s:6:\\"result\\";a:3:{s:9:\\"is_active\\";b:1;s:7:\\"message\\";s:0:\\"\\";s:7:\\"user_id\\";i:3;}}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"},"createdAt":1767076273,"delay":null}',
                'attempts' => 0,
                'reserved_at' => NULL,
                'available_at' => 1767076273,
                'created_at' => 1767076273,
            ),
            8 => 
            array (
                'id' => 12,
                'queue' => 'default',
                'payload' => '{"uuid":"3e8cb523-247f-46bd-abc6-26fd379efb10","displayName":"App\\\\Events\\\\NotifyEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:22:\\"App\\\\Events\\\\NotifyEvent\\":2:{s:7:\\"message\\";s:29:\\"Seeding finished successfully\\";s:5:\\"color\\";s:5:\\"green\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"},"createdAt":1767088455,"delay":null}',
                'attempts' => 0,
                'reserved_at' => NULL,
                'available_at' => 1767088455,
                'created_at' => 1767088455,
            ),
            9 => 
            array (
                'id' => 13,
                'queue' => 'default',
                'payload' => '{"uuid":"bb84659c-e3fe-4993-b6ac-504b2bba1be4","displayName":"App\\\\Events\\\\NotifyEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:22:\\"App\\\\Events\\\\NotifyEvent\\":2:{s:7:\\"message\\";s:21:\\"Seeding files updated\\";s:5:\\"color\\";s:5:\\"green\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"},"createdAt":1767088455,"delay":null}',
                'attempts' => 0,
                'reserved_at' => NULL,
                'available_at' => 1767088455,
                'created_at' => 1767088455,
            ),
            10 => 
            array (
                'id' => 14,
                'queue' => 'default',
                'payload' => '{"uuid":"0d55dcca-b3b7-40f6-957e-cdaa4a2dff5d","displayName":"App\\\\Events\\\\NotifyEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:22:\\"App\\\\Events\\\\NotifyEvent\\":2:{s:7:\\"message\\";s:29:\\"Seeding finished successfully\\";s:5:\\"color\\";s:5:\\"green\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"},"createdAt":1767088477,"delay":null}',
                'attempts' => 0,
                'reserved_at' => NULL,
                'available_at' => 1767088477,
                'created_at' => 1767088477,
            ),
            11 => 
            array (
                'id' => 15,
                'queue' => 'default',
                'payload' => '{"uuid":"bec83d29-2e40-4918-907f-65c30c8bed44","displayName":"App\\\\Events\\\\NotifyEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:22:\\"App\\\\Events\\\\NotifyEvent\\":2:{s:7:\\"message\\";s:21:\\"Seeding files updated\\";s:5:\\"color\\";s:5:\\"green\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"},"createdAt":1767088477,"delay":null}',
                'attempts' => 0,
                'reserved_at' => NULL,
                'available_at' => 1767088477,
                'created_at' => 1767088477,
            ),
            12 => 
            array (
                'id' => 16,
                'queue' => 'default',
                'payload' => '{"uuid":"44bc899e-afb9-406b-823d-55540c631ed0","displayName":"App\\\\Events\\\\NotifyEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:22:\\"App\\\\Events\\\\NotifyEvent\\":2:{s:7:\\"message\\";s:29:\\"Seeding finished successfully\\";s:5:\\"color\\";s:5:\\"green\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"},"createdAt":1767088500,"delay":null}',
                'attempts' => 0,
                'reserved_at' => NULL,
                'available_at' => 1767088500,
                'created_at' => 1767088500,
            ),
            13 => 
            array (
                'id' => 17,
                'queue' => 'default',
                'payload' => '{"uuid":"d593fdb5-1386-40af-8bbd-cac23874da13","displayName":"App\\\\Events\\\\NotifyEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:22:\\"App\\\\Events\\\\NotifyEvent\\":2:{s:7:\\"message\\";s:21:\\"Seeding files updated\\";s:5:\\"color\\";s:5:\\"green\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"},"createdAt":1767088500,"delay":null}',
                'attempts' => 0,
                'reserved_at' => NULL,
                'available_at' => 1767088500,
                'created_at' => 1767088500,
            ),
        ));
        
        
    }
}