<template>
    <div class="prose">
        <div
            class="border rounded-lg"
            :class="{ 'border-red-500': errorMessage }"
        >
            <div
                v-if="editor"
                class="flex flex-wrap gap-1 p-2 border-b bg-gray-50 sticky top-0 z-[999]"
            >
                <!-- Toolbar Buttons -->
                <q-btn
                    dense
                    :flat="!editor.isActive('bold')"
                    icon="format_bold"
                    @click="editor.chain().focus().toggleBold().run()"
                />
                <q-btn
                    dense
                    :flat="!editor.isActive('italic')"
                    icon="format_italic"
                    @click="editor.chain().focus().toggleItalic().run()"
                />
                <q-btn
                    dense
                    :flat="!editor.isActive('underline')"
                    icon="format_underlined"
                    @click="editor.chain().focus().toggleUnderline().run()"
                />
                <q-btn
                    :flat="!editor.isActive('heading')"
                    :label="$translate('Formatting')"
                    size="small"
                >
                    <q-menu>
                        <q-card>
                            <div v-for="(size, index) in 6" :key="size">
                                <q-btn
                                    class="w-[100px]"
                                    :label="`Heading ${size}`"
                                    size="small"
                                    :flat="
                                        !editor.isActive('heading', {
                                            level: size,
                                        })
                                    "
                                    :style="{ fontSize: 12 + index + 'px' }"
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleHeading({ level: size })
                                            .run()
                                    "
                                />
                            </div>
                        </q-card>
                    </q-menu>
                </q-btn>
                <q-btn :label="$translate('Add row')" size="small" flat>
                    <q-menu>
                        <q-card>
                            <div v-for="size in 12" :key="size">
                                <q-btn
                                    class="w-[200px]"
                                    :label="`Row with ${size} columns`"
                                    size="small"
                                    flat
                                    @click="() => insertGridRow(size, editor)"
                                />
                            </div>
                        </q-card>
                    </q-menu>
                </q-btn>
                <q-btn
                    dense
                    icon="format_list_bulleted"
                    :flat="!editor.isActive('bulletList')"
                    @click="editor.chain().focus().toggleBulletList().run()"
                />
                <q-btn
                    dense
                    icon="format_list_numbered"
                    :flat="!editor.isActive('orderedList')"
                    @click="editor.chain().focus().toggleOrderedList().run()"
                />
                <q-btn
                    dense
                    flat
                    icon="remove"
                    @click="editor.chain().focus().setHorizontalRule().run()"
                />

                <q-btn
                    dense
                    flat
                    @click="editor.chain().focus().setHardBreak().run()"
                    :label="$translate('Hard break')"
                />

                <!-- Table Controls -->
                <q-btn dense flat icon="table_chart" @click="addTable" />
                <q-btn dense flat icon="colorize">
                    <q-menu>
                        <q-color
                            model-value="#000"
                            @update:model-value="
                                color =>
                                    editor.chain().focus().setColor(color).run()
                            "
                        />
                    </q-menu>
                </q-btn>
                <q-btn
                    v-if="editor.isActive('table')"
                    dense
                    flat
                    icon="add_box"
                    @click="editor.chain().focus().addColumnAfter().run()"
                />
                <q-btn
                    dense
                    :flat="!editor.isActive('blockquote')"
                    icon="format_quote"
                    @click="editor.chain().focus().toggleBlockquote().run()"
                />
                <q-btn
                    v-if="editor.isActive('table')"
                    dense
                    flat
                    icon="table_rows"
                    @click="editor.chain().focus().addRowAfter().run()"
                />

                <!-- Media Controls -->
                <q-btn dense flat icon="image" @click="openImageUpload" />
                <q-btn
                    dense
                    flat
                    icon="ondemand_video"
                    @click="openVideoDialog"
                />
                <protected-component
                    permission-key="public-information-informations-access"
                >
                    <q-btn
                        dense
                        flat
                        icon="public"
                        label="exam"
                        @click="openExam('exam')"
                    />
                    <q-btn
                        dense
                        flat
                        icon="public"
                        label="document"
                        @click="openExam('document')"
                    />
                </protected-component>
                <q-btn
                    dense
                    flat
                    icon="ondemand_video"
                    @click="openVideoDialog"
                />
            </div>

            <div>
                <editor-content
                    :editor="editor"
                    class="p-4 min-h-[400px] overflow-auto"
                />
            </div>
            <input
                ref="imageInput"
                type="file"
                accept="image/*"
                class="hidden"
                @change="handleImageUpload"
            />
        </div>

        <div v-if="errorMessage" class="mt-1 text-sm text-red-500">
            {{ errorMessage }}
        </div>

        <!-- Video Dialog -->
        <q-dialog v-model="videoDialogOpen">
            <q-card style="min-width: 400px">
                <q-card-section>
                    <div class="text-h6">Insert Video</div>
                </q-card-section>

                <q-card-section>
                    <q-input v-model="videoUrl" label="Video URL" outlined />
                </q-card-section>

                <q-card-actions align="right">
                    <q-btn flat label="Cancel" color="primary" v-close-popup />
                    <q-btn
                        label="Insert"
                        color="primary"
                        @click="insertVideo"
                    />
                </q-card-actions>
            </q-card>
        </q-dialog>
        <q-dialog v-model="examDialogOpen">
            <q-card style="min-width: 600px" class="w-full max-w-md mx-auto">
                <q-card-section>
                    <div class="text-h6">
                        Select the Public {{ publicType ? publicType : '' }}
                    </div>
                </q-card-section>

                <q-card-section>
                    <select-component
                        :url="`${appRoutes.blog_management.information.api}?type=${publicType}`"
                        :multiple="false"
                        :on-change="
                            data => {
                                exam_id = data?.id
                            }
                        "
                        :label="$translate(`Select ${publicType} `)"
                        option-label="title"
                        option-value="id"
                        v-model="exam_id"
                        class-name="w-full max-w-md mx-auto"
                    />
                </q-card-section>

                <q-card-actions align="right">
                    <q-btn flat label="Cancel" color="primary" v-close-popup />
                    <q-btn
                        label="inject exam"
                        color="primary"
                        @click="enjectExam"
                    />
                </q-card-actions>
            </q-card>
        </q-dialog>

        <!-- Card Dialog -->
        <q-dialog v-model="cardDialogOpen">
            <q-card style="min-width: 400px">
                <q-card-section>
                    <div class="text-h6">Add Content Card</div>
                </q-card-section>

                <q-card-section>
                    <q-file
                        v-model="cardImage"
                        label="Card Image"
                        accept="image/*"
                        outlined
                    />
                    <q-input
                        v-model="cardTitle"
                        label="Title"
                        class="mt-4"
                        outlined
                    />
                    <q-input
                        v-model="cardDescription"
                        label="Description"
                        class="mt-4"
                        outlined
                        type="textarea"
                    />
                </q-card-section>

                <q-card-actions align="right">
                    <q-btn flat label="Cancel" color="primary" v-close-popup />
                    <q-btn
                        label="Add Card"
                        color="primary"
                        @click="insertCard"
                    />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </div>
</template>
<style>
.ProseMirror {
    min-height: 200px;
    outline: none;
}
</style>
<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue'
import { Editor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'
import Image from '@tiptap/extension-image'
import SelectComponent from '../SelectComponent.vue'
import { appRoutes } from 'src/appRouter/routes'
import {
    Table,
    TableRow,
    TableHeader,
    TableCell,
} from '@tiptap/extension-table'
import Iframe from '@edifice-tiptap-extensions/extension-iframe'
import { Node } from '@tiptap/core'
import { GridColumn, GridRow, insertGridRow } from 'src/lib/GridRow'
import { Color, TextStyle } from '@tiptap/extension-text-style'
import { ListItem } from '@tiptap/extension-list'
import ProtectedComponent from 'components/ProtectedComponent.vue'
import ImageResize from 'tiptap-extension-resize-image'

// Custom Card Node Extension
const CardNode = Node.create({
    name: 'card',
    group: 'block',
    defining: true,
    isolating: true,

    addAttributes() {
        return {
            title: { default: '' },
            description: { default: '' },
            imageUrl: { default: '' },
        }
    },

    parseHTML() {
        return [{ tag: 'div[data-type="card"]' }]
    },

    renderHTML({ HTMLAttributes }) {
        return [
            'div',
            {
                'data-type': 'card',
                class: 'border rounded-lg overflow-hidden my-4 shadow-md',
            },
            [
                'img',
                {
                    src: HTMLAttributes.imageUrl,
                    class: 'w-full h-48 object-cover',
                },
            ],
            [
                'div',
                { class: 'p-4' },
                [
                    'h3',
                    { class: 'text-xl font-bold mb-2' },
                    HTMLAttributes.title,
                ],
                ['p', { class: 'text-gray-600' }, HTMLAttributes.description],
            ],
        ]
    },
})

const VideoNode = Node.create({
    name: 'video',
    group: 'block',
    selectable: true,
    draggable: true,

    addAttributes() {
        return {
            src: { default: null },
        }
    },

    parseHTML() {
        return [{ tag: 'iframe[data-type="video"]' }]
    },

    renderHTML({ HTMLAttributes }) {
        return [
            'iframe',
            {
                ...HTMLAttributes,
                'data-type': 'video',
                frameborder: 0,
                allowfullscreen: 'true',
                class: 'w-full h-96 my-4 rounded',
            },
        ]
    },
})

// Custom Card Node Extension
const GridNode = Node.create({
    name: 'gridView',
    group: 'block',
    defining: true,
    isolating: true,

    addAttributes() {
        return {
            col: { default: 1 },
        }
    },

    parseHTML() {
        return [{ tag: 'div[data-type="gridView"]' }]
    },

    renderHTML({ HTMLAttributes }) {
        return [
            'div',
            {
                'data-type': 'gridView',
                class: `grid grid-cols-${HTMLAttributes.col} gap-3`,
            },
            ['div', { class: 'p-4 border' }],
        ]
    },
})

const props = defineProps({
    defaultValue: String,
    errorMessage: String,
})

const emit = defineEmits(['onChange'])

// Editor instance
const editor = ref(null)
const imageInput = ref(null)

// Video dialog
const videoDialogOpen = ref(false)
const videoUrl = ref('')

// Card dialog
const cardDialogOpen = ref(false)
const cardImage = ref(null)
const cardTitle = ref('')
const cardDescription = ref('')

// Initialize editor
onMounted(() => {
    editor.value = new Editor({
        extensions: [
            StarterKit,
            Underline,
            Image.configure({ inline: true, allowBase64: true }),
            Table.configure({ resizable: true }),
            TableRow,
            TableHeader,
            TableCell,
            Iframe.configure({ allowFullscreen: true }),
            CardNode, // Add our custom card node
            GridNode,
            GridRow,
            GridColumn,
            ImageResize.configure({
                inline: true,
                allowBase64: true,
                // Optional: limit resizing
                minWidth: 50,
                maxWidth: 800,
                allowResizeInPercentages: false,
            }),
            Color.configure({ types: [TextStyle.name, ListItem.name] }),
            TextStyle.configure({ types: [ListItem.name] }),
            VideoNode,
        ],
        content: props.defaultValue || '',
        onUpdate: () => {
            emit('onChange', editor.value.getHTML())
        },
    })
})

// Cleanup editor
onBeforeUnmount(() => {
    editor.value?.destroy()
})

// Watch for defaultValue changes
watch(
    () => props.defaultValue,
    newValue => {
        if (newValue && newValue !== editor.value?.getHTML()) {
            editor.value.commands.setContent(newValue)
        }
    },
)

// Image handling
const openImageUpload = () => imageInput.value.click()

const handleImageUpload = event => {
    const file = event.target.files[0]
    if (!file) return

    const reader = new FileReader()
    reader.onload = e => {
        editor.value.chain().focus().setImage({ src: e.target.result }).run()
    }
    reader.readAsDataURL(file)
    event.target.value = ''
}

// Video handling
const openVideoDialog = () => {
    videoUrl.value = ''
    videoDialogOpen.value = true
}

const insertVideo = () => {
    if (!videoUrl.value) return

    let embedUrl = videoUrl.value

    // YouTube
    if (
        videoUrl.value.includes('youtube.com') ||
        videoUrl.value.includes('youtu.be')
    ) {
        const videoId =
            videoUrl.value.split('v=')[1] || videoUrl.value.split('/').pop()
        embedUrl = `https://www.youtube.com/embed/${videoId}`
    }

    // Vimeo
    if (videoUrl.value.includes('vimeo.com')) {
        const videoId = videoUrl.value.split('/').pop()
        embedUrl = `https://player.vimeo.com/video/${videoId}`
    }

    // Insert as custom video node
    editor.value
        .chain()
        .focus()
        .insertContent({
            type: 'video',
            attrs: { src: embedUrl },
        })
        .run()

    videoDialogOpen.value = false
}

// Table creation
const addTable = () => {
    editor.value
        .chain()
        .focus()
        .insertTable({ rows: 3, cols: 3, withHeaderRow: true })
        .run()
}

const exam_id = ref(null)
const examDialogOpen = ref(false)
const publicType = ref(null)
// Card handling
const openCardDialog = () => {
    cardImage.value = null
    cardTitle.value = ''
    cardDescription.value = ''
    cardDialogOpen.value = true
}
const enjectExam = () => {
    const placeholder = `{{${publicType.value}_${exam_id.value}}}`

    editor.value.chain().focus().insertContent(placeholder).run()
    examDialogOpen.value = false
}
const openExam = type => {
    publicType.value = type
    exam_id.value = null
    examDialogOpen.value = true
}
const insertGrid = col => {
    editor.value
        .chain()
        .focus()
        .insertContent({
            type: 'gridView',
            attrs: {
                col,
            },
        })
        .run()
}

const insertCard = () => {
    if (!cardImage.value) return

    const reader = new FileReader()
    reader.onload = e => {
        editor.value
            .chain()
            .focus()
            .insertContent({
                type: 'card',
                attrs: {
                    title: cardTitle.value,
                    description: cardDescription.value,
                    imageUrl: e.target.result,
                },
            })
            .run()

        cardDialogOpen.value = false
    }
    reader.readAsDataURL(cardImage.value)
}
</script>

<style>
/* Tiptap table styling */
.ProseMirror {
    table {
        border-collapse: collapse;
        margin: 0;
        overflow: hidden;
        table-layout: fixed;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #ced4da;
        box-sizing: border-box;
        min-width: 1em;
        padding: 0.5rem;
        position: relative;
        vertical-align: top;
    }

    th {
        background-color: #f1f3f5;
        font-weight: bold;
        text-align: left;
    }

    iframe {
        width: 100%;
        height: 400px;
        margin: 1rem 0;
    }

    [data-type='card'] {
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        overflow: hidden;
        margin: 1rem 0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .ProseMirror img {
        display: inline-block;
        max-width: 100%;
        height: auto;
        resize: both;
        overflow: auto;
    }

    .ProseMirror .resize-handle {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 10px;
        height: 10px;
        background: rgba(0, 0, 0, 0.5);
        cursor: se-resize;
    }
}
</style>
