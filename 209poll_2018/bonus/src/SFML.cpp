/*
** EPITECH PROJECT, 2019
** 209poll_2018
** File description:
** SFML
*/

#include <iomanip>
#include <sstream>
#include "SFML.hpp"
#include "Explode.hpp"
#include "Calculs.hpp"

SFML::SFML() : _window(sf::VideoMode(640, 480), "Would you prefer...", sf::Style::Close)
{
    _background.loadFromFile("./assets/start.png");
    _poll.loadFromFile("./assets/white.png");
    _font.loadFromFile("./assets/font.ttf");
    _window.setKeyRepeatEnabled(false);
}

SFML::~SFML()
{
    _window.close();
}

bool SFML::isRunning()
{
    return (_window.isOpen());
}

void SFML::clear()
{
    _window.display();
    _window.clear();
}

int SFML::drawStart()
{
    while (_window.pollEvent(_event)) {
        if (_event.type == sf::Event::Closed)
            _window.close();
    }
    if (sf::Mouse::isButtonPressed(sf::Mouse::Left)) {
        sf::Vector2i position = sf::Mouse::getPosition(_window);
        if (position.x >= 215 && position.x <= 455 &&
            position.y >= 250 && position.y <= 305)
                _window.close();
        else if (position.x >= 215 && position.x <= 455 &&
                 position.y >= 185 && position.y <= 240)
                 return (1);
    }
    _box.setTexture(_background);
    _window.draw(_box);
    return (0);
}

void SFML::beforeStarting(std::string const &filename1, std::string const &filename2)
{
    std::string file1("./assets/");
    std::string file2("./assets/");

    _lorr = -1;
    file1.append(filename1);
    file2.append(filename2);
    file1.append(".png");
    file2.append(".png");
    _background.loadFromFile("./assets/main.png");
    _concurrent1.loadFromFile(file1);
    _concurrent2.loadFromFile(file2);
}

std::string SFML::updateLeft(std::string &data)
{
    std::vector<std::string> line = Explode::explode(data, '=');
    int popu = std::stoi(line.at(2));
    popu += 1;
    std::vector<std::string> left = Explode::explode(line.at(1), ';');
    int lef = std::stoi(left.at(0));
    lef += 1;
    data = line.at(0);
    data.append("=");
    data.append(std::to_string(lef));
    data.append(";");
    data.append(left.at(1));
    data.append("=");
    data.append(std::to_string(popu));
    _lorr = 0;
    return (data);
}

std::string SFML::updateRight(std::string &data)
{
    std::vector<std::string> line = Explode::explode(data, '=');
    int popu = std::stoi(line.at(2));
    popu += 1;
    std::vector<std::string> right = Explode::explode(line.at(1), ';');
    int rig = std::stoi(right.at(1));
    rig += 1;
    data = line.at(0);
    data.append("=");
    data.append(right.at(0));
    data.append(";");
    data.append(std::to_string(rig));
    data.append("=");
    data.append(std::to_string(popu));
    _lorr = 1;
    return (data);
}

void SFML::drawPoll(int population, std::string const &data)
{
    _white.setTexture(_poll);
    _window.draw(_c1);
    _window.draw(_c2);
    _window.draw(_box);
    _window.draw(_white);
    
    std::vector<std::string> vec = Explode::explode(data, '=');
    int pop = std::stoi(vec.at(2));
    std::vector<std::string> ratio = Explode::explode(vec.at(1), ';');
    double percent = 0;
    if (_lorr == 0)
        percent = std::stoi(ratio.at(0)) * 100.0 / (double)pop;
    else
        percent = std::stoi(ratio.at(1)) * 100.0 / (double)pop;

    Calculs calculs(population, pop, percent);

    double p = calculs.getPercent();
    std::stringstream stream;
    stream << std::fixed << std::setprecision(2) << p;
    std::string s = stream.str();

    /* %% */

    s.append("%");
    _stats.setString(s);
    _stats.setFont(_font);
    _stats.setCharacterSize(60);
    _stats.setColor(sf::Color::Black);

    if (_lorr == 0)
        _stats.setPosition(90, 100);
    else
        _stats.setPosition(410, 100);

    _window.draw(_stats);
    
    /* 95% */
    s.assign("95% confidence interval\n");
    _stats.setString(s);
    _stats.setCharacterSize(20);

    if (_lorr == 0)
        _stats.setPosition(70, 200);
    else
        _stats.setPosition(380, 200);

    _window.draw(_stats);

    /* 95% calcs */
    s.assign("[");

    double f95 = calculs.getf95() * 100;
    std::stringstream f5stream;
    f5stream << std::fixed << std::setprecision(2) << f95;
    s.append(f5stream.str());
    
    s.append("%, ");

    double s95 = calculs.gets95() * 100;
    std::stringstream s5stream;
    s5stream << std::fixed << std::setprecision(2) << s95;
    s.append(s5stream.str());

    s.append("%]");
    _stats.setString(s);
    _stats.setCharacterSize(27);

    if (_lorr == 0)
        _stats.setPosition(95, 220);
    else
        _stats.setPosition(405, 220);

    _window.draw(_stats);

    /* 99% */
    s.assign("99% confidence interval\n");
    _stats.setString(s);
    _stats.setCharacterSize(20);

    if (_lorr == 0)
        _stats.setPosition(70, 280);
    else
        _stats.setPosition(380, 280);

    _window.draw(_stats);

    /* 99% calcs */
    s.assign("[");

    double f99 = calculs.getf99() * 100;
    std::stringstream f9stream;
    f9stream << std::fixed << std::setprecision(2) << f99;
    s.append(f9stream.str());
    
    s.append("%, ");

    double s99 = calculs.gets99() * 100;
    std::stringstream s9stream;
    s9stream << std::fixed << std::setprecision(2) << s99;
    s.append(s9stream.str());

    s.append("%]");
    _stats.setString(s);
    _stats.setCharacterSize(27);

    if (_lorr == 0)
        _stats.setPosition(95, 300);
    else
        _stats.setPosition(405, 300);

    _window.draw(_stats);

}

int SFML::drawMain(std::string &data)
{
    while (_window.pollEvent(_event)) {
        if (_event.type == sf::Event::Closed)
            _window.close();
    }
    if (sf::Mouse::isButtonPressed(sf::Mouse::Left)) {
        sf::Vector2i position = sf::Mouse::getPosition(_window);
        if (position.x >= 260 && position.x <= 370 &&
            position.y >= 450 && position.y <= 480)
            return (4);
        else if (position.x <= 320) {
            data = updateLeft(data);
            return (3);
        } else {
            data = updateRight(data);
            return (3);
        }
    }
    _box.setTexture(_background);
    _c1.setTexture(_concurrent1);
    _c2.setTexture(_concurrent2);
    _c2.setPosition(320, 0);
    _window.draw(_c1);
    _window.draw(_c2);
    _window.draw(_box);
    return (2);
}
