<?php
     require_once 'config.php';
    require_once 'telegram.php';
    require_once 'deepseek.php';

// Основной обработчик
$update = json_decode(file_get_contents('php://input'), true);

if (isset($update['message'])) {
    $chat_id = $update['message']['chat']['id'];
    $text = isset($update['message']['text']) ? $update['message']['text'] : '';
    $user_name = isset($update['message']['from']['first_name']) ? $update['message']['from']['first_name'] : 'Пользователь';

    // Логируем запрос
    file_put_contents('bot.log', date('Y-m-d H:i:s') . " - {$user_name}: {$text}\n", FILE_APPEND);

    // Обработка команды /start
    if (strpos($text, '/start') === 0) {
        sendMessage($chat_id, "🤖 Я ваш AI-помощник! Отправьте мне информацию для запоминания, затем задавайте вопросы.");
        return;
    }

    // Обработка сообщений
    handleMessage($chat_id, $text, $user_name);
}

function handleMessage($chat_id, $text, $user_name) {
    // Если сообщение длинное - запоминаем
    if (strlen($text) > 100) {
        saveToKnowledge($text);
        sendMessage($chat_id, "✅ Запомнил!");
        return;
    }

    // Получаем базу знаний
    $knowledge = getKnowledge();

    // Если база пуста
    if (empty($knowledge)) {
        sendMessage($chat_id, "📝 Сначала отправьте информацию для обучения.");
        return;
    }

    // Формируем контекст из последних 3 записей
    $context = implode("\n", array_slice($knowledge, -3));

    // Создаем промпт
    $prompt = "Отвечай на основе информации:\n\n{$context}\n\nВопрос: {$text}\n\nОтвет:";

    // Получаем ответ от DeepSeek
    $answer = askDeepSeek($prompt);

    if ($answer) {
        sendMessage($chat_id, $answer);
    } else {
        sendMessage($chat_id, "⚠️ Ошибка, попробуйте позже");
    }
}

function saveToKnowledge($text) {
    $knowledge = getKnowledge();
    $knowledge[] = $text;
    file_put_contents('knowledge.json', json_encode($knowledge, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function getKnowledge() {
    if (file_exists('knowledge.json')) {
        return json_decode(file_get_contents('knowledge.json'), true) ?: [];
    }
    return [];
}
