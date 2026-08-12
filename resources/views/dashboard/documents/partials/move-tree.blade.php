{{--
    Рекурсивное дерево папок для выбора места назначения.
    Ожидает: $nodes (массив узлов), $treeId (уникальный префикс), $formId (id формы переноса).
--}}
<ul class="list-unstyled mb-0 {{ ($level ?? 0) > 0 ? 'ms-4' : '' }}">
    @foreach ($nodes as $node)
        @php $collapseId = 'moveNode'.$treeId.'_'.$node['id']; @endphp
        <li class="py-1">
            <div class="d-flex align-items-center gap-1">
                @if (! empty($node['children']))
                    <button type="button" class="btn btn-sm btn-link p-0 text-decoration-none text-muted" style="width: 1.25rem;"
                            data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="false">▸</button>
                @else
                    <span class="d-inline-block" style="width: 1.25rem;"></span>
                @endif
                <label class="d-flex align-items-center gap-2 mb-0 flex-grow-1" style="cursor: pointer;">
                    <input class="form-check-input mt-0 flex-shrink-0" type="radio" name="target_id" value="{{ $node['id'] }}" form="{{ $formId }}" />
                    <span class="text-break">📁 {{ $node['name'] }}</span>
                </label>
            </div>
            @if (! empty($node['children']))
                <div class="collapse" id="{{ $collapseId }}">
                    @include('dashboard.documents.partials.move-tree', [
                        'nodes' => $node['children'],
                        'treeId' => $treeId,
                        'formId' => $formId,
                        'level' => ($level ?? 0) + 1,
                    ])
                </div>
            @endif
        </li>
    @endforeach
</ul>
